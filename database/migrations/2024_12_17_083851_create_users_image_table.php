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
        Schema::create('users_image', function (Blueprint $table) {
            $table->char('bp', 10);
            $table->text('image_data');

            // Define foreign keys
            $table->foreign('bp')->references('BP')->on('m_employee_general_info')->onDelete('cascade');

            $table->primary(['bp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_image');
    }
};
