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
            CREATE OR REPLACE VIEW public.vwdots_happrovallevel
            AS SELECT cost_center,
                max(
                    CASE
                        WHEN level = 1 THEN cost_center_apv
                        ELSE NULL::bpchar
                    END) AS cost_center_apv_1,
                max(
                    CASE
                        WHEN level = 2 THEN cost_center_apv
                        ELSE NULL::bpchar
                    END) AS cost_center_apv_2
            FROM vwdots_approvallevel
            GROUP BY cost_center
            ORDER BY cost_center;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS public.vwdots_happrovallevel');
    }
};
