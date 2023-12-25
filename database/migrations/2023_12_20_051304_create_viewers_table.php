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
        Schema::create('viewers', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->integer('phone')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('account_number')->nullable();
            $table->string('account_balance')->default(0);
            $table->string('code')->nullable();
            $table->string('password');
            $table->string('password_bank')->nullable();
            $table->string('level_id');
            $table->string('presenter_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viewers');
    }
};
