<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;
use App\Models\Timeslot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class AppointmentController extends Controller
{

    /**
     * Autentifikovanie usera pomocou tokenu a vratenie.
     */
    private function authenticate(Request $request)
    {
        $token = $request->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://identify_service:8080/api/user');  //  URL Identity Service musi sedet s portom aj adresa

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }



    /**
     * Zobrazit appointmenty
     */
    public function index(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $appointments = Appointment::with(['patient', 'timeslot'])->get();
        return response()->json($appointments);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string',
            'personal_number' => 'required|string',
            'email'           => 'required|email',
            'timeslot_id'     => 'required|exists:timeslots,id',
            'contact_number'  => 'required|string|min:10|max:16',
            'description'     => 'nullable|string',
        ]);

        $patients = Patient::where('name', $validated['name'])->get();
        $patient = $patients->first(function ($p) use ($validated) {
            return Hash::check($validated['personal_number'], $p->personal_number);
        });

        if (!$patient) {
            return response()->json(['message' => 'Invalid patient data provided.'], 403);
        }

        $timeslot = Timeslot::find($validated['timeslot_id']);
        if ($timeslot->is_booked) {
            return response()->json(['message' => 'This timeslot is already booked.'], 409);
        }

        $token = Str::random(60);
        $expiresAt = now()->addMinutes(10);

        cache()->put("appointment_verification:{$token}", json_encode($validated), $expiresAt);

        Http::post('http://email_service:8000/api/send-verification-email', [
            'email' => $validated['email'],
            'name'  => $validated['name'],
            'verification_url' => url("/appointments/verify/{$token}"),
        ]);

        return response()->json([
            'message' => 'Please check your email to verify your appointment within 10 minutes.'
        ], 201);
    }



    public function verify($token)
    {
        $appointmentData = cache()->get("appointment_verification:{$token}");

        if (!$appointmentData) {
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        }

        $appointmentData = json_decode($appointmentData, true);

        $patient = Patient::where('name', $appointmentData['name'])->first();
        if (!$patient || !\Illuminate\Support\Facades\Hash::check($appointmentData['personal_number'], $patient->personal_number)) {
            return redirect('/')->with('error', 'Invalid patient data.');
        }

        $timeslot = Timeslot::find($appointmentData['timeslot_id']);
        if (!$timeslot || $timeslot->is_booked) {
            return redirect('/')->with('error', 'This timeslot is no longer available.');
        }

        $appointment = Appointment::create([
            'patient_id'     => $patient->id,
            'timeslot_id'    => $appointmentData['timeslot_id'],
            'contact_number' => $appointmentData['contact_number'],
            'email'          => $appointmentData['email'],
            'description'    => $appointmentData['description'],
            'status'         => 'confirmed',
        ]);

        $timeslot->update(['is_booked' => true]);

        cache()->forget("appointment_verification:{$token}");

        Http::post('http://email_service:8000/api/send-confirmation-email', [
            'email'         => $appointment->email,
            'name'          => $appointment->patient->name,
            'date'          => $appointment->timeslot->date,
            'time'          => "{$appointment->timeslot->start_time} - {$appointment->timeslot->end_time}",
            'contact_number' => $appointment->contact_number,
            'description'    => $appointment->description,
        ]);

        return redirect('http://localhost:5173/verification-success');
    }


    /**
     * Detail konkretnetneho appointmentu.
     */
    public function show(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $appointment = Appointment::with(['patient', 'timeslot'])->find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }

        return response()->json($appointment);
    }

    /**
     * update appointmentu
     */
    public function update(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }

        $validated = $request->validate([
            'timeslot_id' => 'nullable|exists:timeslots,id',
            'contact_number' => 'nullable|string|min:10|max:15',
            'description' => 'nullable|string',
        ]);


        if (isset($validated['timeslot_id'])) {
            $newTimeslot = Timeslot::find($validated['timeslot_id']);
            if ($newTimeslot->is_booked) {
                return response()->json(['message' => 'This timeslot is already booked'], 409);
            }

            $appointment->timeslot->update(['is_booked' => false]);

            $appointment->update(['timeslot_id' => $validated['timeslot_id']]);
            $newTimeslot->update(['is_booked' => true]);
        }

        $appointment->update(array_filter($validated));

        return response()->json($appointment);
    }


    public function destroy(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }

        $appointment->timeslot->update(['is_booked' => false]);

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
