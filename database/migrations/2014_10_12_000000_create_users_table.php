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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('phone_number_verified_at' , ['yes','no'])->default('no');
            $table->enum('status' , ['benefaction' , 'not_benefaction'])->default('not_benefaction');
            $table->string('account_amount');
            $table->enum('role' , ['admin' , 'user'])->default('user');
            $table->timestamps();
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
