<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
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

    public function index() {
        return response()->json(Service::all());
    }

    public function store(Request $request) {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
        ]);

        $service = Service::create($request->all());
        return response()->json($service, 201);
    }

    public function show($id) {
        return response()->json(Service::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return response()->json($service);
    }

    public function destroy(Request $request, $id) {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json(['message' => 'Service deleted successfully']);
    }
}
