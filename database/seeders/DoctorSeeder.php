<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['msl_code' => 'MSL001', 'name' => 'Dr. Arun Kumar', 'state' => 'Maharashtra', 'city' => 'Mumbai', 'status' => 'active', 'zone' => 'West Zone', 'speciality' => 'Cardiologist', 'first_visit' => '2024-01-15', 'educator_id' => 1, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL002', 'name' => 'Dr. Sita Rao', 'state' => 'Karnataka', 'city' => 'Bangalore', 'status' => 'active', 'zone' => 'South Zone', 'speciality' => 'Diabetologist', 'first_visit' => '2024-02-10', 'educator_id' => 2, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL003', 'name' => 'Dr. Manish Gupta', 'state' => 'Delhi', 'city' => 'Delhi', 'status' => 'active', 'zone' => 'North Zone', 'speciality' => 'Physician', 'first_visit' => '2024-01-20', 'educator_id' => 3, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL004', 'name' => 'Dr. Lakshmi Iyer', 'state' => 'Tamil Nadu', 'city' => 'Chennai', 'status' => 'active', 'zone' => 'South Zone', 'speciality' => 'Neurologist', 'first_visit' => '2024-03-05', 'educator_id' => 4, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL005', 'name' => 'Dr. Prakash Shah', 'state' => 'Gujarat', 'city' => 'Ahmedabad', 'status' => 'active', 'zone' => 'West Zone', 'speciality' => 'Gastroenterologist', 'first_visit' => '2024-02-15', 'educator_id' => 5, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL006', 'name' => 'Dr. Meera Jain', 'state' => 'Rajasthan', 'city' => 'Jaipur', 'status' => 'active', 'zone' => 'North Zone', 'speciality' => 'Pulmonologist', 'first_visit' => '2024-01-25', 'educator_id' => 1, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL007', 'name' => 'Dr. Suresh Bose', 'state' => 'West Bengal', 'city' => 'Kolkata', 'status' => 'active', 'zone' => 'East Zone', 'speciality' => 'Nephrologist', 'first_visit' => '2024-03-10', 'educator_id' => 2, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL008', 'name' => 'Dr. Anita Verma', 'state' => 'Uttar Pradesh', 'city' => 'Lucknow', 'status' => 'active', 'zone' => 'North Zone', 'speciality' => 'Oncologist', 'first_visit' => '2024-02-20', 'educator_id' => 3, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL009', 'name' => 'Dr. Ramesh Nair', 'state' => 'Kerala', 'city' => 'Kochi', 'status' => 'active', 'zone' => 'South Zone', 'speciality' => 'Dermatologist', 'first_visit' => '2024-01-30', 'educator_id' => 4, 'created_at' => Carbon::now()],
            ['msl_code' => 'MSL010', 'name' => 'Dr. Seema Kapoor', 'state' => 'Punjab', 'city' => 'Chandigarh', 'status' => 'active', 'zone' => 'North Zone', 'speciality' => 'Orthopedic', 'first_visit' => '2024-03-15', 'educator_id' => 5, 'created_at' => Carbon::now()],
        ];

        DB::table('public.doctor')->insert($doctors);
    }
}
