<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['state' => 'Maharashtra', 'zone' => 'West Zone', 'country' => 'India'],
            ['state' => 'Karnataka', 'zone' => 'South Zone', 'country' => 'India'],
            ['state' => 'Delhi', 'zone' => 'North Zone', 'country' => 'India'],
            ['state' => 'Tamil Nadu', 'zone' => 'South Zone', 'country' => 'India'],
            ['state' => 'Gujarat', 'zone' => 'West Zone', 'country' => 'India'],
            ['state' => 'Rajasthan', 'zone' => 'North Zone', 'country' => 'India'],
            ['state' => 'West Bengal', 'zone' => 'East Zone', 'country' => 'India'],
            ['state' => 'Uttar Pradesh', 'zone' => 'North Zone', 'country' => 'India'],
            ['state' => 'Kerala', 'zone' => 'South Zone', 'country' => 'India'],
            ['state' => 'Punjab', 'zone' => 'North Zone', 'country' => 'India'],
        ];

        DB::table('common.states')->insert($states);
    }
}
