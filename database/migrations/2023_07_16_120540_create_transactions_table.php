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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->bigInteger('users_id');

            $table->date('event_date')->nullable();
            $table->string('name', 150)->nullable();
            $table->text('address')->nullable();
            $table->text('detail_order')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_url')->nullable();

            $table->integer('total_price');
            $table->string('status', 25);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
