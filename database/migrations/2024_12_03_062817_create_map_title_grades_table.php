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
        Schema::create('map_title_grade', function (Blueprint $table) {
            $table->char('title_id', 5); // Foreign key to titles
            $table->char('grade_id', 10); // Not currently a foreign key
            $table->primary(['title_id', 'grade_id']); // Composite primary key

            // Foreign key constraint for title_id
            $table->foreign('title_id')->references('title_id')->on('m_title')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_title_grade');
    }
};
