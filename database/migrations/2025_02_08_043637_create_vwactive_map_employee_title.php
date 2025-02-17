<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW public.vwactive_map_employee_title
        AS SELECT \"BP\",
            cost_center,
            title_id,
            type,
            seq_nbr,
            status_pekerjaan,
            start_effective_date,
            end_effective_date,
            remark
           FROM map_employee_title
          WHERE now() >= COALESCE(start_effective_date, '2023-01-01'::date) AND now() <= COALESCE(end_effective_date, '2999-12-31'::date);
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS public.vwactive_map_employee_title');
    }
};
