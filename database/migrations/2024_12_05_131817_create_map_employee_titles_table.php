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
        Schema::create('map_employee_title', function (Blueprint $table) {
            $table->char('BP', 10); // Foreign Key
            $table->char('cost_center', 10)->nullable(); // Foreign Key
            $table->char('title_id', 5)->nullable(); // Foreign Key
            $table->string('type')->nullable(); // Foreign Key
            $table->integer('seq_nbr');
            $table->string("status_pekerjaan")->nullable();
            $table->date('start_effective_date');
            $table->date('end_effective_date')->nullable();
            $table->string('remark', 255)->nullable();

            // Composite Primary Key
            $table->primary(['BP', 'cost_center', 'title_id', 'seq_nbr']);

            // Foreign Key Constraints
            $table->foreign('BP')
                ->references('BP') // References the 'BP' column
                ->on('m_employee_general_info') // On the 'm_employee_general_info' table
                ->cascadeOnDelete()->onUpdate('cascade');

            $table->foreign('cost_center')->references('cost_center')->on('map_cost_center_hierarchy')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('title_id')->references('title_id')->on('m_title')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_employee_title');
    }
};
