<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingHour;
use App\Models\DaysOff;
use App\Models\Timeslot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ScheduleController extends Controller
{

    private function authenticate(Request $request)
    {
        $token = $request->bearerToken();
        $response = \Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://identify_service:8080/api/user');

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Ziskanie pracovneho casu (working schedule)
     *
     */
    public function index()
    {
        $workingHours = WorkingHour::all();
        $daysOff = DaysOff::all();

        return response()->json([
            'working_hours' => $workingHours,
            'days_off' => $daysOff,
        ]);
    }

    /**
     * nastavenie alebo update working hours
     */
    public function setWorkingHours(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $validated = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:5|max:120',
            'days' => 'required|array',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        ]);

        $workingHour = WorkingHour::updateOrCreate([], $validated);

        return response()->json($workingHour, 201);
    }

    /**
     * pridanie alebo uprava days off.
     */
    public function setDaysOff(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string',
        ]);

        $dayOff = DaysOff::updateOrCreate(
            ['date' => $validated['date']],
            $validated
        );

        return response()->json($dayOff, 201);
    }

    /**
     * generator timeslotov.
     */
    public function generateTimeslots(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $workingHours = WorkingHour::first();
        if (!$workingHours) {
            return response()->json(['message' => 'No working hours set.'], 400);
        }

        $daysOff = DaysOff::pluck('date')->toArray();
        $slotDuration = $workingHours->slot_duration;

        $startTime = Carbon::createFromFormat('H:i:s', $workingHours->start_time);
        $endTime = Carbon::createFromFormat('H:i:s', $workingHours->end_time);

        $period = CarbonPeriod::create($validated['start_date'], $validated['end_date']);

        foreach ($period as $date) {
            $dayName = $date->format('l');

            if (in_array($dayName, $workingHours->days) && !in_array($date->toDateString(), $daysOff)) {
                $currentSlot = $startTime->copy();

                while ($currentSlot->lessThan($endTime)) {
                    $slotEnd = $currentSlot->copy()->addMinutes($slotDuration);

                    Timeslot::firstOrCreate([
                        'date' => $date->toDateString(),
                        'start_time' => $currentSlot->toTimeString(),
                        'end_time' => $slotEnd->toTimeString(),
                    ], [
                        'is_booked' => false,
                    ]);

                    $currentSlot = $slotEnd;
                }
            }
        }

        return response()->json(['message' => 'Timeslots generated successfully.']);
    }

    /**
     * Delete a day off.
     */
    public function deleteDaysOff(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $dayOff = DaysOff::find($id);

        if (!$dayOff) {
            return response()->json(['message' => 'Day off not found.'], 404);
        }

        $dayOff->delete();

        return response()->json(['message' => 'Day off deleted successfully.']);
    }

    /**
     * vymazanie a specifickeho timeslot.
     */
    public function deleteTimeslot(Request $request ,$id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }
        $timeslot = Timeslot::find($id);

        if (!$timeslot) {
            return response()->json(['message' => 'Timeslot not found.'], 404);
        }

        if ($timeslot->is_booked) {
            return response()->json(['message' => 'Cannot delete a booked timeslot.'], 403);
        }

        $timeslot->delete();

        return response()->json(['message' => 'Timeslot deleted successfully.']);
    }



    /**
     * Update specifickeho timeslotu.
     */
    public function updateTimeslot(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $timeslot = Timeslot::find($id);

        if (!$timeslot) {
            return response()->json(['message' => 'Timeslot not found.'], 404);
        }

        if ($timeslot->is_booked) {
            return response()->json(['message' => 'Cannot update a booked timeslot.'], 403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
        ]);

        $timeslot->update($validated);

        return response()->json(['message' => 'Timeslot updated successfully.', 'timeslot' => $timeslot]);
    }





    public function getBookedTimeslots(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $bookedTimeslots = Timeslot::where('is_booked', true)->get();

        return response()->json([
            'status' => 'success',
            'booked_timeslots' => $bookedTimeslots,
        ]);
    }


    public function getAvailableTimeslots()
    {
        $availableTimeslots = Timeslot::where('is_booked', false)->get();

        return response()->json([
            'status' => 'success',
            'available_timeslots' => $availableTimeslots,
        ]);
    }


    public function getAllSchedules(Request $request)
    {

        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $timeslots = Timeslot::orderBy('date')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'status' => 'success',
            'timeslots' => $timeslots,
        ]);
    }

}
