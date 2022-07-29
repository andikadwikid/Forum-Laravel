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
        Schema::create('image_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->string('answer_id', 255);
            $table->text('image_name')->nullable();
            $table->timestamps();

            // $table->foreign('answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_answers');
    }
};
