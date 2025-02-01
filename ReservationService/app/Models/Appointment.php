<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    use HasFactory;

    protected $fillable = ['patient_id', 'timeslot_id', 'contact_number', 'email', 'description', 'status', 'verification_token'];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }
}
