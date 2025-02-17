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
        Schema::create('m_application', function (Blueprint $table) {

            $table->char('app_id', 5);

            // Application name column (text)
            $table->text('app_name');

            // Application URL column (text)
            $table->text('app_url');

            $table->text('img_url')->nullable();

            $table->string('environment');
            $table->primary('app_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_application');
    }
};
