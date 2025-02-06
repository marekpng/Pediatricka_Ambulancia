<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Timeslot extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'start_time', 'end_time', 'is_booked'];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('j.n.Y'); 
    }
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('j.n.Y', $value)->format('Y-m-d');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
