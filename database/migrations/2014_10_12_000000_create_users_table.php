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
            $table->string('name', 150);
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 75);

            $table->string('photo', 200)->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('roles', 10)->default('USER');

            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
