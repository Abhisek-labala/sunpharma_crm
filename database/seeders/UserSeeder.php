<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Counsellors
            ['emp_id' => 'CNS001', 'full_name' => 'Priya Sharma', 'email' => 'priya.counsellor@sunpharma.com', 'user_name' => 'priyac', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543210', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'zone_id' => 1, 'role' => 'counsellor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'CNS002', 'full_name' => 'Amit Kumar', 'email' => 'amit.counsellor@sunpharma.com', 'user_name' => 'amitc', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543211', 'city' => 'Delhi', 'state' => 'Delhi', 'zone_id' => 2, 'role' => 'counsellor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'CNS003', 'full_name' => 'Sneha Patel', 'email' => 'sneha.counsellor@sunpharma.com', 'user_name' => 'snehac', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543212', 'city' => 'Bangalore', 'state' => 'Karnataka', 'zone_id' => 3, 'role' => 'counsellor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
            // Digital Counsellors
            ['emp_id' => 'DCN001', 'full_name' => 'Rahul Verma', 'email' => 'rahul.digital@sunpharma.com', 'user_name' => 'rahuld', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543213', 'city' => 'Chennai', 'state' => 'Tamil Nadu', 'zone_id' => 4, 'role' => 'digitalcounsellor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'DCN002', 'full_name' => 'Kavita Singh', 'email' => 'kavita.digital@sunpharma.com', 'user_name' => 'kavitad', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543214', 'city' => 'Pune', 'state' => 'Maharashtra', 'zone_id' => 1, 'role' => 'digitalcounsellor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'DCN003', 'full_name' => 'Rajesh Gupta', 'email' => 'rajesh.digital@sunpharma.com', 'user_name' => 'rajeshd', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543215', 'city' => 'Ahmedabad', 'state' => 'Gujarat', 'zone_id' => 5, 'role' => 'digitalcounsellor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
            // NC (Nurse Coordinator)
            ['emp_id' => 'NC001', 'full_name' => 'Meera Nair', 'email' => 'meera.nc@sunpharma.com', 'user_name' => 'meeranc', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543216', 'city' => 'Kochi', 'state' => 'Kerala', 'zone_id' => 6, 'role' => 'nc', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'NC002', 'full_name' => 'Anita Reddy', 'email' => 'anita.nc@sunpharma.com', 'user_name' => 'anitanc', 'password' => hash('sha256', 'password123'), 'raw_password' => 'password123', 'mobile' => '9876543217', 'city' => 'Hyderabad', 'state' => 'Telangana', 'zone_id' => 7, 'role' => 'nc', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
            // Admin
            ['emp_id' => 'ADM001', 'full_name' => 'Vikram Joshi', 'email' => 'admin@sunpharma.com', 'user_name' => 'admin', 'password' => hash('sha256', 'admin123'), 'raw_password' => 'admin123', 'mobile' => '9876543218', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'zone_id' => 1, 'role' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'ADM002', 'full_name' => 'Sunita Kapoor', 'email' => 'sunita.admin@sunpharma.com', 'user_name' => 'sunitaadmin', 'password' => hash('sha256', 'admin123'), 'raw_password' => 'admin123', 'mobile' => '9876543219', 'city' => 'Delhi', 'state' => 'Delhi', 'zone_id' => 2, 'role' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('common.users')->insert($users);
    }
}
