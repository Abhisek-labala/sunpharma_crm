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
            ['compitetor_name' => 'Sun Pharma', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Dr. Reddys', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Cipla', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Lupin', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Torrent Pharma', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Zydus Cadila', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Alkem Laboratories', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Glenmark', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Abbott India', 'status' => 'active', 'created_at' => Carbon::now()],
            ['compitetor_name' => 'Pfizer India', 'status' => 'active', 'created_at' => Carbon::now()],
        ];

        DB::table('common.compitetor')->insert($competitors);
    }
}
