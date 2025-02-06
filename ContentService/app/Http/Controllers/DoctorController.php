<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{

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

    public function index()
    {
        return response()->json(Doctor::all());
    }

    public function store(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/doctors');
            $validated['image'] = str_replace('public/', 'storage/', $path);
        }

        $doctor = Doctor::create($validated);

        $doctor->image = url($doctor->image);

        return response()->json($doctor, 201);
    }

    public function show(Doctor $doctor)
    {
        return response()->json($doctor);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'department' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($doctor->image) {
                Storage::delete(str_replace('/storage/', 'public/', $doctor->image));
            }

            $path = $request->file('image')->store('public/doctors');
            $validated['image'] = str_replace('public/', '/storage/', $path);
        }

        $doctor->update($validated);

        return response()->json($doctor);
    }


    public function destroy(Request $request,Doctor $doctor)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        if ($doctor->image) {
            Storage::delete($doctor->image);
        }
        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
