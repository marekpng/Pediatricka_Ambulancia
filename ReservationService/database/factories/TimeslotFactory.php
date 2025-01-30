<?php

namespace Database\Factories;

use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timeslot>
 */
class TimeslotFactory extends Factory
{
    protected $model = Timeslot::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        $startTime = $this->faker->time;
        $endTime = date('H:i:s', strtotime($startTime . ' +30 minutes'));

        return [
            'date' => $this->faker->date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_booked' => false,
        ];
    }
}
