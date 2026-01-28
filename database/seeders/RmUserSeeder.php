<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RmUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['emp_id' => 'RM001', 'full_name' => 'Rajesh Kumar', 'email' => 'rajesh.kumar@sunpharma.com', 'user_name' => 'rajeshk', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543210', 'zone_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM002', 'full_name' => 'Priya Sharma', 'email' => 'priya.sharma@sunpharma.com', 'user_name' => 'priyas', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543211', 'zone_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM003', 'full_name' => 'Amit Singh', 'email' => 'amit.singh@sunpharma.com', 'user_name' => 'amits', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543212', 'zone_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM004', 'full_name' => 'Sneha Patel', 'email' => 'sneha.patel@sunpharma.com', 'user_name' => 'snehap', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543213', 'zone_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM005', 'full_name' => 'Vikram Reddy', 'email' => 'vikram.reddy@sunpharma.com', 'user_name' => 'vikramr', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543214', 'zone_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM006', 'full_name' => 'Kavita Gupta', 'email' => 'kavita.gupta@sunpharma.com', 'user_name' => 'kavitag', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543215', 'zone_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM007', 'full_name' => 'Arjun Nair', 'email' => 'arjun.nair@sunpharma.com', 'user_name' => 'arjunn', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543216', 'zone_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM008', 'full_name' => 'Pooja Verma', 'email' => 'pooja.verma@sunpharma.com', 'user_name' => 'poojav', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543217', 'zone_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM009', 'full_name' => 'Rohit Mehta', 'email' => 'rohit.mehta@sunpharma.com', 'user_name' => 'rohitm', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543218', 'zone_id' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['emp_id' => 'RM010', 'full_name' => 'Anjali Das', 'email' => 'anjali.das@sunpharma.com', 'user_name' => 'anjalid', 'password' => hash('sha256', 'password'), 'raw_password' => 'password', 'role' => 'rc', 'mobile' => '9876543219', 'zone_id' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('common.rm_users')->insert($users);
    }
}
