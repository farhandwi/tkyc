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
        Schema::create('m_title', function (Blueprint $table) {
            $table->char('title_id', 5); // Primary Key
            $table->string('title_name', 255);
            $table->boolean('is_head'); // Boolean field
            $table->date('start_effective_date');
            $table->date('end_effective_date')->nullable(); // Nullable end date

            // Define primary key
            $table->primary('title_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_title');
    }
};
