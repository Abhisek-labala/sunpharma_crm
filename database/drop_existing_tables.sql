-- Drop all existing tables from common and public schemas
-- Run this script before running php artisan migrate:fresh

-- Drop common schema tables
DROP TABLE IF EXISTS common.medicines CASCADE;
DROP TABLE IF EXISTS common.medicine_headers CASCADE;
DROP TABLE IF EXISTS common.zones CASCADE;
DROP TABLE IF EXISTS common.states CASCADE;
DROP TABLE IF EXISTS common.cities CASCADE;
DROP TABLE IF EXISTS common.compitetor CASCADE;
DROP TABLE IF EXISTS common.rm_users CASCADE;
DROP TABLE IF EXISTS common.users CASCADE;

-- Drop public schema tables
DROP TABLE IF EXISTS public.doctor CASCADE;
DROP TABLE IF EXISTS public.patient_details CASCADE;
DROP TABLE IF EXISTS public.feedback_submitted CASCADE;
DROP TABLE IF EXISTS public.day3_followup CASCADE;
DROP TABLE IF EXISTS public.day7_followup CASCADE;
DROP TABLE IF EXISTS public.day15_followup CASCADE;
DROP TABLE IF EXISTS public.day30_followup CASCADE;
DROP TABLE IF EXISTS public.day45_followup CASCADE;
DROP TABLE IF EXISTS public.day60_followup CASCADE;
DROP TABLE IF EXISTS public.day90_followup CASCADE;
DROP TABLE IF EXISTS public.day120_followup CASCADE;
DROP TABLE IF EXISTS public.day150_followup CASCADE;
DROP TABLE IF EXISTS public.day180_followup CASCADE;

-- Drop other tables (no schema prefix)
DROP TABLE IF EXISTS patient_medication_details CASCADE;
DROP TABLE IF EXISTS attendances CASCADE;
DROP TABLE IF EXISTS login_logs CASCADE;
