<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert([
            [
                'name' => 'Marek Jaros',
                'date_of_birth' => '2001-11-28',
                'personal_number' => Hash::make('011128/5944'),
                'contact_number' => '0915 359 202',
                'address' => 'Lovcica 222'
            ],
            [
                'name' => 'Jane Smith',
                'date_of_birth' => '2017-07-15',
                'personal_number' => Hash::make('0987654321'),
                'contact_number' => '555-5678',
                'address' => '456 Oak Avenue'
            ],
            [
                'name' => 'Emily Johnson',
                'date_of_birth' => '2018-12-10',
                'personal_number' => Hash::make('1122334455'),
                'contact_number' => '555-9876',
                'address' => '789 Pine Lane'
            ],
        ]);
    }
}
