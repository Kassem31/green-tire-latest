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
        Schema::create('inspection_transaction_observations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inspection_transaction_id');
            $table->bigInteger('observation_id');
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreign('inspection_transaction_id')->references('id')->on('inspection_transactions');
            $table->foreign('observation_id')->references('id')->on('observations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_transaction_observations');
    }
};
