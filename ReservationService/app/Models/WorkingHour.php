<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_time',    
        'end_time',      
        'slot_duration', 
        'days',          
    ];

   
    public function getDaysAttribute($value)
    {
        return json_decode($value, true);
    }

    
    public function setDaysAttribute($value)
    {
        $this->attributes['days'] = json_encode($value);
    }
}
