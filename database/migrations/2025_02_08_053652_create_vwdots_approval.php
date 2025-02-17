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
    public function up(): void
    {
        DB::statement("
       CREATE OR REPLACE VIEW public.vwdots_approval
        AS SELECT a.cost_center,
            a.cost_center_name,
            c.cost_center_apv_1,
            c.cost_center_apv_2,
            b.\"BP\",
            b.employee_name,
            COALESCE(b.role_user,
                CASE
                    WHEN b.cost_center = a.cost_center_dh THEN 'DH'::text
                    WHEN b.cost_center = a.cost_center_gh THEN 'GH'::text
                    ELSE NULL::text
                END) AS role_user,
            b.title_name,
            b.email,
            b.sex,
            b.is_head,
            b.start_effective_date,
            b.end_effective_date
        FROM vwdotsactive_map_cost_center_hierarchy a
            JOIN vwdots_happrovallevel c ON a.cost_center = c.cost_center
            LEFT JOIN ( SELECT c_1.cost_center,
                    a_1.\"BP\",
                    NULL::text AS role_user,
                        CASE
                            WHEN b_1.is_male THEN 'MALE'::text
                            ELSE 'FEMALE'::text
                        END AS sex,
                    TRIM(BOTH FROM a_1.name) AS employee_name,
                    COALESCE(
                        CASE
                            WHEN NOT c_1.type::text = 'DEFINITIVE'::text THEN c_1.type::text || ' '::text
                            ELSE NULL::text
                        END, ''::text) || d.title_name::text AS title_name,
                    a_1.email,
                    d.is_head,
                    c_1.start_effective_date,
                    c_1.end_effective_date
                FROM m_employee_general_info a_1
                    JOIN m_employee_additional b_1 ON a_1.\"BP\" = b_1.\"BP\"
                    JOIN vwactive_map_employee_title c_1 ON a_1.\"BP\" = c_1.\"BP\"
                    JOIN vwactive_m_title d ON d.title_id = c_1.title_id AND d.is_head = true
                WHERE (EXISTS ( SELECT 1
                        FROM map_cost_center_hierarchy e
                        WHERE (e.cost_center = e.cost_center_dh OR e.cost_center = e.cost_center_gh) AND c_1.cost_center = e.cost_center))
                UNION
                SELECT f.cost_center,
                    a_1.\"BP\",
                        CASE
                            WHEN f.user_role ~~ 'VD%'::text THEN 'DH'::text
                            ELSE 'GH'::text
                        END AS role_user,
                        CASE
                            WHEN b_1.is_male THEN 'MALE'::text
                            ELSE 'FEMALE'::text
                        END AS sex,
                    TRIM(BOTH FROM a_1.name) AS employee_name,
                    ( SELECT string_agg(COALESCE(
                                CASE
                                    WHEN NOT c_1.type::text = 'DEFINITIVE'::text THEN c_1.type::text || ' '::text
                                    ELSE NULL::text
                                END, ''::text) || d.title_name::text, ' & '::text) AS title_name
                        FROM vwactive_map_employee_title c_1
                            JOIN vwactive_m_title d ON d.title_id = c_1.title_id
                        WHERE a_1.\"BP\" = c_1.\"BP\") AS title_name,
                    a_1.email,
                        CASE
                            WHEN (EXISTS ( SELECT 1
                            FROM vwactive_map_employee_title c_1
                                JOIN vwactive_m_title d ON d.title_id = c_1.title_id
                            WHERE a_1.\"BP\" = c_1.\"BP\" AND d.is_head = true)) THEN true
                            ELSE false
                        END AS is_head,
                    f.create_date AS start_effective_date,
                    f.expired_date AS end_effective_date
                FROM foreign_mapping_bp_user_types f
                    JOIN m_employee_general_info a_1 ON f.bp::bpchar = a_1.\"BP\"
                    JOIN m_employee_additional b_1 ON a_1.\"BP\" = b_1.\"BP\"
                WHERE f.user_role = ANY (ARRAY['VD001'::bpchar, 'VG001'::bpchar])) b ON a.cost_center = b.cost_center
        ORDER BY a.cost_center;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS public.vwdots_approval');
    }
};
