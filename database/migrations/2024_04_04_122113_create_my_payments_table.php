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
        Schema::create('my_payments', function (Blueprint $table) {
            $table->id();
            $table->string('topic_id');
            $table->string('transaction_number');
            $table->string('amount_paid');
            $table->string('date');
            $table->enum('status' , ['successful' , 'unsuccessful' , 'failure_to_complete_the_project']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_payments');
    }
};
