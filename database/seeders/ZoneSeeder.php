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
            ['zone_name' => 'North', 'created_at' => Carbon::now()],
            ['zone_name' => 'South', 'created_at' => Carbon::now()],
            ['zone_name' => 'East', 'created_at' => Carbon::now()],
            ['zone_name' => 'West', 'created_at' => Carbon::now()],
        ];

        DB::table('common.zones')->insert($zones);
    }
}
