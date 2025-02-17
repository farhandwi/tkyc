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
        Schema::create('m_reference', function (Blueprint $table) {
            $table->char('ref_id', 5); // Part of the composite primary key
            $table->char('ref_code', 5); // Part of the composite primary key
            $table->char('ref_id_group', 5);
            $table->char('header_flag', 1);
            $table->string('description', 255);
            $table->string('create_by', 255);
            $table->dateTime('create_date');
            $table->string('modify_by', 255);
            $table->dateTime('modify_date');
            $table->dateTime('expiry_date')->nullable(); // Nullable expiry_date

            // Define the composite primary key
            $table->primary(['ref_id', 'ref_code']); // Composite primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_reference');
    }
};
