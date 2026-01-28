<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropExistingTablesCommand extends Command
{
    protected $signature = 'db:drop-existing-tables';
    protected $description = 'Drop all existing tables from common and public schemas';

    public function handle()
    {
        $this->info('Dropping existing tables...');

        $tables = [
            // Common schema tables
            'common.users',
            'common.medicines',
            'common.medicine_headers',
            'common.zones',
            'common.states',
            'common.cities',
            'common.compitetor',
            'common.rm_users',
            
            // Public schema tables
            'public.doctor',
            'public.patient_details',
            'public.feedback_submitted',
            'public.day3_followup',
            'public.day7_followup',
            'public.day15_followup',
            'public.day30_followup',
            'public.day45_followup',
            'public.day60_followup',
            'public.day90_followup',
            'public.day120_followup',
            'public.day150_followup',
            'public.day180_followup',
            
            // Other tables
            'patient_medication_details',
            'attendances',
            'login_logs',
        ];

        foreach ($tables as $table) {
            try {
                DB::statement("DROP TABLE IF EXISTS {$table} CASCADE");
                $this->line("✓ Dropped: {$table}");
            } catch (\Exception $e) {
                $this->warn("✗ Could not drop {$table}: " . $e->getMessage());
            }
        }

        $this->info('Done! You can now run: php artisan migrate');
        
        return 0;
    }
}
