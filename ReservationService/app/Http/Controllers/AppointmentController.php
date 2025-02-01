<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;
use App\Models\Timeslot;

class AppointmentController extends Controller
{
//
//    /**
//     * Autentifikovanie usera pomocou tokenu a vratenie.
//     */
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
            'name' => 'required|string',
            'personal_number' => 'required|string',
            'timeslot_id' => 'required|exists:timeslots,id',
            'contact_number' => 'required|string|min:10|max:16',
            'description' => 'nullable|string',
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


        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'timeslot_id' => $validated['timeslot_id'],
            'contact_number' => $validated['contact_number'],
            'description' => $validated['description'],
        ]);

        $timeslot->update(['is_booked' => true]);

        return response()->json($appointment, 201);
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
