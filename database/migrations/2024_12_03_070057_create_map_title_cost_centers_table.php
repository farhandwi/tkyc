<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('map_title_cost_center', function (Blueprint $table) {
            $table->char('title_id', 5); // Foreign key to m_title
            $table->char('cost_center', 10); // Foreign key to m_cost_center
            $table->primary(['title_id', 'cost_center']); // Composite primary key

            // Foreign key constraints
            $table->foreign('title_id')->references('title_id')->on('m_title')->onDelete('cascade');
            $table->foreign('cost_center')->references('cost_center')->on('map_cost_center_hierarchy')->onDelete('cascade')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_title_cost_center');
    }
};
