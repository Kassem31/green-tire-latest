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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_super_admin')->default(false);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();

            $table->string('username')->nullable();
            $table->string('normalized_user_name')->nullable();
            $table->string('surname')->nullable();
            $table->boolean('email_confirmed')->default(false);
            $table->string('security_stamp')->nullable();
            $table->boolean('is_external')->default(false);
            $table->string('phone_number', 16)->nullable();
            $table->boolean('phone_number_confirmed')->default(false);
            $table->boolean('two_factor_enabled')->default(false);
            $table->dateTime('lockout_end')->nullable();
            $table->boolean('lockout_enabled')->default(false);
            $table->integer('access_failed_count')->default(0);
            $table->boolean('should_change_password_on_next_login')->default(false);
            $table->integer('entity_version')->default(0);
            $table->dateTime('last_password_change_time')->nullable();
            $table->string('concurrency_stamp', 40)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->timestamp('modified_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
