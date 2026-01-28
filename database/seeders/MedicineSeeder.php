<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = [
            ['medicine_name' => 'Atorvastatin', 'medicine_header_id' => 1, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Metformin', 'medicine_header_id' => 2, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Amlodipine', 'medicine_header_id' => 3, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Salbutamol', 'medicine_header_id' => 4, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Pantoprazole', 'medicine_header_id' => 5, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Gabapentin', 'medicine_header_id' => 6, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Furosemide', 'medicine_header_id' => 7, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Cisplatin', 'medicine_header_id' => 8, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Hydrocortisone', 'medicine_header_id' => 9, 'status' => 'active', 'created_at' => Carbon::now()],
            ['medicine_name' => 'Ibuprofen', 'medicine_header_id' => 10, 'status' => 'active', 'created_at' => Carbon::now()],
        ];

        DB::table('common.medicines')->insert($medicines);
    }
}
