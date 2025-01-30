<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showAuthenticatedUser(Request $request)
    {
        // The request user is automatically injected into the request by Sanctum middleware
        return response()->json($request->user());
    }
}
