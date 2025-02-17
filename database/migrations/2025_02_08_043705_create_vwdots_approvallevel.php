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
        CREATE OR REPLACE VIEW public.vwdots_approvallevel
        AS WITH approval_data AS (
                SELECT vwdotsactive_map_cost_center_hierarchy.cost_center,
                    vwdotsactive_map_cost_center_hierarchy.cost_center_dh,
                    vwdotsactive_map_cost_center_hierarchy.cost_center_gh
                FROM vwdotsactive_map_cost_center_hierarchy
                WHERE vwdotsactive_map_cost_center_hierarchy.cost_center_dh IS NOT NULL OR vwdotsactive_map_cost_center_hierarchy.cost_center_gh IS NOT NULL
                UNION ALL
                SELECT vwdotsactive_map_cost_center_hierarchy.cost_center,
                    vwdotsactive_map_cost_center_hierarchy.cost_center AS cost_center_dh,
                    NULL::bpchar AS cost_center_gh
                FROM vwdotsactive_map_cost_center_hierarchy
                WHERE vwdotsactive_map_cost_center_hierarchy.cost_center_dh IS NULL AND vwdotsactive_map_cost_center_hierarchy.cost_center_gh IS NULL
                ), level_data AS (
                SELECT approval_data.cost_center,
                    COALESCE(approval_data.cost_center_dh, approval_data.cost_center_gh) AS cost_center_apv,
                    1 AS level
                FROM approval_data
                UNION ALL
                SELECT approval_data.cost_center,
                    approval_data.cost_center_gh AS cost_center_apv,
                    2 AS level
                FROM approval_data
                WHERE approval_data.cost_center_dh IS NOT NULL AND approval_data.cost_center_gh IS NOT NULL
                )
        SELECT cost_center,
            level,
            cost_center_apv
        FROM level_data a
        ORDER BY cost_center, level;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS public.vwdots_approvallevel');
    }
};
