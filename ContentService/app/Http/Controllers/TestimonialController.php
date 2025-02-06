<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestimonialController extends Controller
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
        return response()->json(Testimonial::all());
    }

    public function store(Request $request) {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }


        $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'quote' => 'required|string',
        ]);

        $testimonial = Testimonial::create($request->all());
        return response()->json($testimonial, 201);
    }

    public function update(Request $request, $id) {

        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'quote' => 'required|string',
        ]);

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($request->all());

        return response()->json($testimonial);
    }

    public function destroy(Request $request, $id) {

        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
