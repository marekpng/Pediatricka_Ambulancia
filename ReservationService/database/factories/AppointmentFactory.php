<?php

namespace Database\Factories;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'patient_id' => Patient::factory(),
            'timeslot_id' => Timeslot::factory(),
            'contact_number' => $this->faker->phoneNumber,
            'description' => $this->faker->sentence,
        ];
    }
}
