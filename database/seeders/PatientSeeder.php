<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['uuid' => Str::uuid(), 'educator_id' => 1, 'digital_educator_id' => 1, 'hcp_id' => 1, 'patient_name' => 'Rahul Sharma', 'age' => 45, 'mobile_number' => '9123456780', 'gender' => 'Male', 'medicine' => 'Atorvastatin', 'medicine_header' => 'Cardiovascular', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-01-15', 'approved_status' => 'Approved', 'patient_city' => 'Mumbai', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 2, 'digital_educator_id' => 2, 'hcp_id' => 2, 'patient_name' => 'Priya Desai', 'age' => 38, 'mobile_number' => '9123456781', 'gender' => 'Female', 'medicine' => 'Metformin', 'medicine_header' => 'Diabetes', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-01-20', 'approved_status' => 'Approved', 'patient_city' => 'Bangalore', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 3, 'digital_educator_id' => 3, 'hcp_id' => 3, 'patient_name' => 'Vikram Singh', 'age' => 52, 'mobile_number' => '9123456782', 'gender' => 'Male', 'medicine' => 'Amlodipine', 'medicine_header' => 'Hypertension', 'cipla_brand_prescribed' => 'No', 'date' => '2024-02-10', 'approved_status' => 'Pending', 'patient_city' => 'Delhi', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 4, 'digital_educator_id' => 4, 'hcp_id' => 4, 'patient_name' => 'Anjali Reddy', 'age' => 41, 'mobile_number' => '9123456783', 'gender' => 'Female', 'medicine' => 'Salbutamol', 'medicine_header' => 'Respiratory', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-02-15', 'approved_status' => 'Approved', 'patient_city' => 'Chennai', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 5, 'digital_educator_id' => 5, 'hcp_id' => 5, 'patient_name' => 'Karthik Patel', 'age' => 35, 'mobile_number' => '9123456784', 'gender' => 'Male', 'medicine' => 'Pantoprazole', 'medicine_header' => 'Gastroenterology', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-03-01', 'approved_status' => 'Approved', 'patient_city' => 'Ahmedabad', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 1, 'digital_educator_id' => 1, 'hcp_id' => 6, 'patient_name' => 'Sunita Joshi', 'age' => 48, 'mobile_number' => '9123456785', 'gender' => 'Female', 'medicine' => 'Gabapentin', 'medicine_header' => 'Neurology', 'cipla_brand_prescribed' => 'No', 'date' => '2024-03-05', 'approved_status' => 'Approved', 'patient_city' => 'Jaipur', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 2, 'digital_educator_id' => 2, 'hcp_id' => 7, 'patient_name' => 'Ravi Das', 'age' => 50, 'mobile_number' => '9123456786', 'gender' => 'Male', 'medicine' => 'Furosemide', 'medicine_header' => 'Nephrology', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-03-10', 'approved_status' => 'Approved', 'patient_city' => 'Kolkata', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 3, 'digital_educator_id' => 3, 'hcp_id' => 8, 'patient_name' => 'Deepa Verma', 'age' => 44, 'mobile_number' => '9123456787', 'gender' => 'Female', 'medicine' => 'Cisplatin', 'medicine_header' => 'Oncology', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-03-15', 'approved_status' => 'Pending', 'patient_city' => 'Lucknow', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 4, 'digital_educator_id' => 4, 'hcp_id' => 9, 'patient_name' => 'Anil Kumar', 'age' => 39, 'mobile_number' => '9123456788', 'gender' => 'Male', 'medicine' => 'Hydrocortisone', 'medicine_header' => 'Dermatology', 'cipla_brand_prescribed' => 'No', 'date' => '2024-03-20', 'approved_status' => 'Approved', 'patient_city' => 'Kochi', 'created_at' => Carbon::now()],
            ['uuid' => Str::uuid(), 'educator_id' => 5, 'digital_educator_id' => 5, 'hcp_id' => 10, 'patient_name' => 'Geeta Malhotra', 'age' => 47, 'mobile_number' => '9123456789', 'gender' => 'Female', 'medicine' => 'Ibuprofen', 'medicine_header' => 'Orthopedics', 'cipla_brand_prescribed' => 'Yes', 'date' => '2024-03-25', 'approved_status' => 'Approved', 'patient_city' => 'Chandigarh', 'created_at' => Carbon::now()],
        ];

        DB::table('public.patient_details')->insert($patients);
    }
}
