<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\MapCostCenterHierarchy;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('map_cost_center_hierarchy', function (Blueprint $table) {
            $table->char('cost_center', 10); // Primary key
            $table->string('cost_center_name', 255)->nullable();
            $table->char('cost_center_direct_report', 10)->nullable();
            $table->char('cost_center_poss', 10)->nullable();
            $table->char('cost_center_dh', 10)->nullable();
            $table->char('cost_center_gh', 10)->nullable();
            $table->char('cost_center_svp', 10)->nullable();
            $table->char('cost_center_dir', 10)->nullable();
            $table->date('start_effective_date')->nullable();
            $table->date('end_effective_date')->nullable();

            // Primary Key constraint
            $table->primary('cost_center');

            // Self-referential foreign key constraints
            $table->foreign('cost_center_direct_report')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('cost_center_poss')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('cost_center_dh')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('cost_center_gh')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('cost_center_svp')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('cost_center_dir')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_cost_center_hierarchy');
    }
};
