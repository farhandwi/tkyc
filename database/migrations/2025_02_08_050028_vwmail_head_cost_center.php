<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class VwmailHeadCostCenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW public.vwmail_head_cost_center
        AS WITH cte_mail AS (
                SELECT row_number() OVER (PARTITION BY a_1.cost_center ORDER BY a_1.seq_nbr, a_1.start_effective_date DESC) AS row_num,
                    a_1.cost_center,
                    a_1.seq_nbr,
                    a_1.start_effective_date,
                    a_1.employee_name,
                    a_1.email
                FROM ( SELECT vwdots_approval.cost_center,
                                CASE
                                    WHEN vwdots_approval.title_name ~~ 'PJS%'::text THEN 1
                                    ELSE 2
                                END AS seq_nbr,
                            vwdots_approval.start_effective_date,
                            (
                                CASE
                                    WHEN vwdots_approval.sex = 'MALE'::text THEN 'Bapak '::text
                                    ELSE 'Ibu '::text
                                END || TRIM(BOTH FROM initcap(vwdots_approval.employee_name))) ||
                                CASE
                                    WHEN vwdots_approval.title_name ~~ 'PJS%'::text THEN ' as '::text || initcap(vwdots_approval.title_name)
                                    ELSE ''::text
                                END AS employee_name,
                            vwdots_approval.email
                        FROM vwdots_approval
                        WHERE vwdots_approval.is_head = true) a_1
                )
        SELECT a.cost_center,
            a.employee_name,
            a.email,
            b.email_cc
        FROM cte_mail a
            LEFT JOIN ( SELECT cte_mail.cost_center,
                    string_agg(DISTINCT cte_mail.email::text, ';'::text) AS email_cc
                FROM cte_mail
                WHERE NOT cte_mail.row_num = 1
                GROUP BY cte_mail.cost_center) b ON a.cost_center = b.cost_center
        WHERE a.row_num = 1;
    ");    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS public.vwmail_head_cost_center');
    }
}