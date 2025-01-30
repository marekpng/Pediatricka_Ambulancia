<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'start_time', 'end_time', 'is_booked'];

    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
