<?php

namespace Database\Factories;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'date_of_birth' => $this->faker->date,
            'personal_number' => $this->faker->unique()->numerify('##########'), #rodne cislo
            'contact_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
        ];
    }
}
