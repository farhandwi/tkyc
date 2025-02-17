<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVwactiveMTitleView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW public.vwactive_m_title AS 
            SELECT 
                title_id,
                title_name,
                is_head,
                start_effective_date,
                end_effective_date
            FROM m_title
            WHERE now() >= COALESCE(start_effective_date, '2023-01-01'::date) 
            AND now() <= COALESCE(end_effective_date, '2999-12-31'::date)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS public.vwactive_m_title');
    }
}