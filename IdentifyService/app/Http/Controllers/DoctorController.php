<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required',
            'description' => 'required',
            'image' => 'url'
        ]);

        $doctor = Doctor::create($request->all());
        return response()->json($doctor, 201);
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required',
            'description' => 'required',
            'image' => 'url'
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());
        return response()->json($doctor);
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return response()->json(null, 204);
    }
}
