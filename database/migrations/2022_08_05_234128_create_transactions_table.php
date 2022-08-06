<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->unsignedBigInteger('premium_id');
            $table->string('transaction_status');
            $table->string('transaction_id');
            $table->string('payment_code')->nullable();
            $table->string('order_id');
            $table->decimal('gross_amount');
            $table->string('payment_type');
            $table->string('transaction_time');
            $table->string('pdf_url')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('premium_id')->references('id')->on('premiums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
