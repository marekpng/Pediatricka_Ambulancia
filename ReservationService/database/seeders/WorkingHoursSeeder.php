<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class WorkingHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('working_hours')->insert([
            'start_time' => '08:00:00',
            'end_time' => '14:30:00',
            'slot_duration' => 30,
            'days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
