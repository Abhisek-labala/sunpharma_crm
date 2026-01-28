<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompitetorSeeder extends Seeder
{
    public function run(): void
    {
        $competitors = [
            ['compitetor_name' => 'Sun Pharma', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Dr. Reddys', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Cipla', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Lupin', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Torrent Pharma', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Zydus Cadila', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Alkem Laboratories', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Glenmark', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Abbott India', 'status' => 1, 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Pfizer India', 'status' => 1, 'created_at' => Carbon::now()],
        ];

        DB::table('common.compitetor')->insert($competitors);
    }
}
