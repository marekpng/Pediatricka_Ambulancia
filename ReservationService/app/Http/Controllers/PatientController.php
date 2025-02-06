<?php


namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    private function authenticate(Request $request)
    {
        $token = $request->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://identify_service:8080/api/user');

        return $response->successful() ? $response->json() : null;
    }


    public function getAllPatientsWithAppointments(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $query = Patient::query();

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $patients = $query->with('appointments.timeslot')->paginate(25);

        return response()->json($patients);
    }



    public function createPatient(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $validated = $request->validate([
            'name'            => 'required|string',
            'date_of_birth'   => 'required|date',
            'personal_number' => 'required|string|unique:patients,personal_number',
            'contact_number'  => 'nullable|string',
            'address'         => 'nullable|string',
        ]);
        $validated['personal_number'] = Hash::make($validated['personal_number']);

        $patient = Patient::create($validated);
        return response()->json($patient, 201);
    }


    public function updatePatient(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }


        $validated = $request->validate([
            'name'            => 'sometimes|required|string',
            'date_of_birth'   => 'sometimes|required|date',
            'personal_number' => 'sometimes|required|string|unique:patients,personal_number,' . $id,
            'contact_number'  => 'nullable|string',
            'address'         => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($validated);
        return response()->json($patient);
    }


    public function deletePatient(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $patient = Patient::findOrFail($id);

        $appointments = Appointment::where('patient_id', $patient->id)->get();

        foreach ($appointments as $appointment) {
            if ($appointment->timeslot) {
                $appointment->timeslot->update(['is_booked' => 0]);
            }
            $appointment->delete();
        }

        $patient->delete();

        return response()->json(['message' => 'Patient and all associated data deleted successfully']);
    }


    public function createAppointmentForPatient(Request $request, $patientId)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $validated = $request->validate([
            'timeslot_id'    => 'required|exists:timeslots,id',
            'contact_number' => 'required|string|min:10|max:16',
            'email'          => 'required|email',
            'description'    => 'nullable|string',
        ]);

        $timeslot = Timeslot::find($validated['timeslot_id']);
        if ($timeslot->is_booked) {
            return response()->json(['message' => 'This timeslot is already booked.'], 409);
        }

        $appointment = Appointment::create([
            'patient_id'     => $patientId,
            'timeslot_id'    => $validated['timeslot_id'],
            'contact_number' => $validated['contact_number'],
            'email'          => $validated['email'],
            'description'    => $validated['description'],
            'status'         => 'confirmed',
        ]);

        $timeslot->update(['is_booked' => true]);

        return response()->json($appointment, 201);
    }


    public function deleteAppointment(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $appointment = Appointment::findOrFail($id);
        $appointment->timeslot->update(['is_booked' => false]);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }

    public function getPatientById(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $patient = Patient::with('appointments.timeslot')->findOrFail($id);
        return response()->json($patient);
    }


    public function getPatientAppointments(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found.'], 404);
        }

        $appointments = Appointment::where('patient_id', $id)
            ->where('status', 'confirmed')
            ->with('timeslot')
            ->get()
            ->sortBy('timeslot.date');

        return response()->json(array_values($appointments->toArray()));
    }


    public function updateAppointment(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $appointment = Appointment::findOrFail($id);
        $oldTimeslot = $appointment->timeslot;

        $validated = $request->validate([
            'timeslot_id' => 'required|exists:timeslots,id',
        ]);

        $newTimeslot = Timeslot::find($validated['timeslot_id']);

        if ($newTimeslot->is_booked) {
            return response()->json(['message' => 'This timeslot is already booked.'], 409);
        }

        $oldTimeslot->update(['is_booked' => false]);

        $appointment->update([
            'timeslot_id' => $validated['timeslot_id'],
        ]);

        $newTimeslot->update(['is_booked' => true]);

        Http::post('http://email_service:8000/api/send-appointment-update-email', [
            'email'          => $appointment->email,
            'name'           => $appointment->patient->name,
            'old_date'       => $oldTimeslot->date,
            'old_time'       => "{$oldTimeslot->start_time} - {$oldTimeslot->end_time}",
            'new_date'       => $newTimeslot->date,
            'new_time'       => "{$newTimeslot->start_time} - {$newTimeslot->end_time}",
            'contact_number' => $appointment->patient->contact_number,
            'description'    => $appointment->description,
        ]);


        return response()->json(['message' => 'Appointment updated successfully.']);
    }



}

