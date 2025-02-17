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
        Schema::create('m_employee_general_info', function (Blueprint $table) {
            $table->char('BP', 10)->primary(); // Primary key
            $table->string('email', 255);
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string("phone_number")->nullable();
            $table->string('KTP')->nullable();
            $table->string("NPWP")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_employee_general_info');
    }
};
