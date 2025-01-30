<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Timeslot;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//        $this->call(PatientSeeder::class);
//        Appointment::factory()
//            ->count(10) // Create 10 example appointments
//            ->create();


        $patients = Patient::factory()->count(10)->create();

        // Create timeslots for today and tomorrow
        $timeslots = Timeslot::factory()->count(20)->create();

        // Create appointments by associating patients and timeslots
        foreach ($timeslots->take(10) as $key => $timeslot) {
            Appointment::factory()->create([
                'patient_id' => $patients->random()->id,
                'timeslot_id' => $timeslot->id,
            ]);

            // Mark timeslot as booked
            $timeslot->update(['is_booked' => true]);
        }
    }
}
