<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentUpdatedMail;
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

    public function sendAppointmentUpdateEmail(Request $request)
    {
        $validated = $request->validate([
            'email'          => 'required|email',
            'name'           => 'required|string',
            'old_date'       => 'required|date',
            'old_time'       => 'required|string',
            'new_date'       => 'required|date',
            'new_time'       => 'required|string',
            'contact_number' => 'required|string',
            'description'    => 'nullable|string',
        ]);

        Mail::to($validated['email'])->send(new AppointmentUpdatedMail($validated));

        return response()->json(['message' => 'Appointment update email sent successfully']);
    }

    public function test(Request $request)
    {
        return $request;
    }
}
