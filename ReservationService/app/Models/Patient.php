<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'date_of_birth', 'personal_number', 'contact_number', 'address'];

   
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
