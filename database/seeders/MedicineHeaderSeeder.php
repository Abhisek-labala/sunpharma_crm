<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicineHeaderSeeder extends Seeder
{
    public function run(): void
    {
        $headers = [
            ['header' => 'Cardiovascular', 'created_at' => Carbon::now()],
            ['header' => 'Diabetes', 'created_at' => Carbon::now()],
            ['header' => 'Hypertension', 'created_at' => Carbon::now()],
            ['header' => 'Respiratory', 'created_at' => Carbon::now()],
            ['header' => 'Gastroenterology', 'created_at' => Carbon::now()],
            ['header' => 'Neurology', 'created_at' => Carbon::now()],
            ['header' => 'Nephrology', 'created_at' => Carbon::now()],
            ['header' => 'Oncology', 'created_at' => Carbon::now()],
            ['header' => 'Dermatology', 'created_at' => Carbon::now()],
            ['header' => 'Orthopedics', 'created_at' => Carbon::now()],
        ];

        DB::table('common.medicine_headers')->insert($headers);
    }
}
