<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentVerificationMail;
use App\Mail\AppointmentConfirmedMail;

class EmailController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        $validated = $request->validate([
            'email'            => 'required|email',
            'name'             => 'required|string',
            'verification_url' => 'required|url',
        ]);

        Mail::to($validated['email'])->send(new AppointmentVerificationMail($validated));

        return response()->json(['message' => 'Verification email sent successfully']);
    }

    public function sendConfirmationEmail(Request $request)
    {
        $validated = $request->validate([
            'email'          => 'required|email',
            'name'           => 'required|string',
            'date'           => 'required|date',
            'time'           => 'required|string',
            'contact_number' => 'required|string',
            'description'    => 'nullable|string',
        ]);

        Mail::to($validated['email'])->send(new AppointmentConfirmedMail($validated));

        return response()->json(['message' => 'Confirmation email sent successfully']);
    }
    public function test(Request $request)
    {
        return $request;
    }
}
