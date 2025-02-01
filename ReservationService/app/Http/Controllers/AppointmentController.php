<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;
use App\Models\Timeslot;
use Illuminate\Support\Str;

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
            return \Illuminate\Support\Facades\Hash::check($validated['personal_number'], $p->personal_number);
        });

        if (!$patient) {
            return response()->json(['message' => 'Invalid patient data provided.'], 403);
        }

        $timeslot = Timeslot::find($validated['timeslot_id']);
        if ($timeslot->is_booked) {
            return response()->json(['message' => 'This timeslot is already booked.'], 409);
        }

        $token = Str::random(60);

        $appointment = Appointment::create([
            'patient_id'         => $patient->id,
            'timeslot_id'        => $validated['timeslot_id'],
            'contact_number'     => $validated['contact_number'],
            'email'              => $validated['email'],
            'description'        => $validated['description'],
            'status'             => 'pending',
            'verification_token' => $token,
        ]);

        $response = Http::post('http://email_service:8000/api/send-verification-email', [
            'email'            => $validated['email'],
            'name'             => $validated['name'],
            'verification_url' => url("/appointments/verify/{$token}"),
        ]);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Appointment created but failed to send verification email.'
            ], 500);
        }

        return response()->json([
            'message' => 'Appointment pending verification. Please check your email to confirm your appointment.'
        ], 201);
    }

    public function verify($token)
    {
        $appointment = Appointment::where('verification_token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$appointment) {
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        }

        $appointment->update([
            'status'             => 'confirmed',
            'verification_token' => null,
        ]);

        $appointment->timeslot->update(['is_booked' => true]);

        $response = Http::post('http://email_service:8000/api/send-confirmation-email', [
            'email'          => $appointment->email,
            'name'           => $appointment->patient->name,
            'date'           => $appointment->timeslot->date,
            'time'           => "{$appointment->timeslot->start_time} - {$appointment->timeslot->end_time}",
            'contact_number' => $appointment->contact_number,
            'description'    => $appointment->description,
        ]);

        if (!$response->successful()) {
            \Log::error('Confirmation email failed for appointment ID: ' . $appointment->id);
        }

        return redirect('http://localhost:5173/verification-success')->with('success', 'Your appointment has been confirmed! Check your email for details.');
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
