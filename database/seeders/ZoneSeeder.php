<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['zone_name' => 'North Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'South Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'East Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'West Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'Central Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'North-East Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'North-West Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'South-East Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'South-West Zone', 'created_at' => Carbon::now()],
            ['zone_name' => 'Metro Zone', 'created_at' => Carbon::now()],
        ];

        DB::table('common.zones')->insert($zones);
    }
}
