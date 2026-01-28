<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['city_name' => 'Mumbai', 'city_code' => 'MUM', 'state_code' => 1], // Maharashtra
            ['city_name' => 'Bangalore', 'city_code' => 'BLR', 'state_code' => 2], // Karnataka
            ['city_name' => 'Delhi', 'city_code' => 'DEL', 'state_code' => 3], // Delhi
            ['city_name' => 'Chennai', 'city_code' => 'CHE', 'state_code' => 4], // Tamil Nadu
            ['city_name' => 'Ahmedabad', 'city_code' => 'AMD', 'state_code' => 5], // Gujarat
            ['city_name' => 'Jaipur', 'city_code' => 'JAI', 'state_code' => 6], // Rajasthan
            ['city_name' => 'Kolkata', 'city_code' => 'KOL', 'state_code' => 7], // West Bengal
            ['city_name' => 'Lucknow', 'city_code' => 'LKO', 'state_code' => 8], // Uttar Pradesh
            ['city_name' => 'Kochi', 'city_code' => 'COK', 'state_code' => 9], // Kerala
            ['city_name' => 'Chandigarh', 'city_code' => 'CHD', 'state_code' => 10], // Punjab
        ];

        DB::table('common.cities')->insert($cities);
    }
}
