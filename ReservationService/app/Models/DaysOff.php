<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaysOff extends Model
{
    use HasFactory;
    protected $table = 'days_off';
    protected $fillable = [
        'date',   
        'reason', 
    ];
}
