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
        Schema::create('repair_transaction_repair_steps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('repair_transaction_id');
            $table->bigInteger('repair_step_id');
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->foreign('repair_transaction_id')->references('id')->on('repair_transactions');
            $table->foreign('repair_step_id')->references('id')->on('repair_steps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_transaction_repair_steps');
    }
};
