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
        Schema::create('m_cost_center', function (Blueprint $table) {
            $table->id(); // Automatically creates an 'id' field as primary key
            $table->integer('old_id')->nullable();
            $table->integer('merge_id')->nullable();
            $table->char('prod_ctr', 4);
            $table->char('cost_ctr', 10);
            $table->char('profit_ctr', 10);
            $table->string('plant');
            $table->text('ct_description');
            $table->text('remark')->nullable();
            $table->text('SKD')->nullable();
            $table->date('TMT');
            $table->date('create_date');
            $table->string('create_by');
            $table->date('exp_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_cost_centers');
    }
};
