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
        Schema::create('map_employee_application', function (Blueprint $table) {
            $table->char('PARTNER', 10); // Define PARTNER as a char(10)
            $table->char('app_id', 5); // Define app_id as a char(10)

            // Define foreign keys
            $table->foreign('PARTNER')->references('BP')->on('m_employee_general_info')->onDelete('cascade');
            $table->foreign('app_id')->references('app_id')->on('m_application')->onDelete('cascade');

            // Define composite primary key
            $table->primary(['PARTNER', 'app_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_employee_application');
    }
};
