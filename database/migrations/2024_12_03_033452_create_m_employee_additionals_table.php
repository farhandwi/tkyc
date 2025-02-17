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
        Schema::create('m_employee_additional', function (Blueprint $table) {
            $table->char('BP', 10); // Foreign Key and Primary Key
            $table->char('PARTNEREXTERNAL', 11);
            $table->string("NIP")->nullable();
            $table->string("NIP_2")->nullable();
            $table->string("UID")->nullable();
            $table->string("agama")->nullable();
            $table->date("tanggal_lahir")->nullable();
            $table->date("tanggal_masuk")->nullable();
            $table->string("fakultas")->nullable();
            $table->string("pendidikan_terakhir")->nullable();
            $table->string("university")->nullable();
            $table->string("lokasi_pekerjaan")->nullable();
            $table->string("status_pekerjaan")->nullable();
            $table->boolean('is_male'); // FK referencing m_reference table
            $table->date('tmt');
            $table->date('end_effective_date')->nullable();
            $table->string('Remark', 255)->nullable();

            // Foreign Key constraint
            $table->foreign('BP')
                ->references('BP') // References the 'BP' column
                ->on('m_employee_general_info') // On the 'm_employee_general_info' table
                ->cascadeOnDelete()->onUpdate('cascade');;



            // Primary Key constraint
            $table->primary('BP');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_employee_additional');
    }
};
