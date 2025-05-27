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
        Schema::create('inspection_transactions', function (Blueprint $table) {
            $table->id();
            $table->text('barcode');
            $table->bigInteger('tire_type_id');
            $table->text('decision');
            $table->boolean('is_repaired')->default(false);
            $table->dateTime('building_date')->nullable();
            $table->text('machine')->nullable();
            $table->text('operator_name')->nullable();
            $table->text('operator_code')->nullable();
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreign('tire_type_id')->references('id')->on('tire_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_transactions');
    }
};
