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
        CREATE OR REPLACE VIEW public.vwdotsactive_map_cost_center_hierarchy
        AS SELECT
                CASE
                    WHEN TRIM(BOTH FROM COALESCE(cost_center_gh, ''::bpchar)) = ''::text THEN cost_center
                    ELSE cost_center_gh
                END AS cc_group,
            cost_center,
            cost_center_name,
            cost_center_direct_report,
            cost_center_poss,
            cost_center_dh,
            cost_center_gh,
            cost_center_svp,
            cost_center_dir,
            start_effective_date,
            end_effective_date
           FROM map_cost_center_hierarchy e
          WHERE NOT cost_center = COALESCE(cost_center_poss, ''::bpchar) AND NOT cost_center = 'TC00000000'::bpchar AND cost_center ~~ 'T%'::text AND NOT cost_center ~~ 'TIC%'::text;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS public.vwdotsactive_map_cost_center_hierarchy');
    }
};
