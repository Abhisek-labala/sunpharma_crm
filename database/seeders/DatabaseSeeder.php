<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call all seeders in order (dependencies first)
        $this->call([
            // Common schema tables (foundational data)
            ZoneSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            MedicineHeaderSeeder::class,
            MedicineSeeder::class,
            CompitetorSeeder::class,
            RmUserSeeder::class,
            UserSeeder::class, // Added users with roles
            
            // Public schema tables (depends on common tables)
            DoctorSeeder::class,
            PatientSeeder::class,
        ]);
    }
}
