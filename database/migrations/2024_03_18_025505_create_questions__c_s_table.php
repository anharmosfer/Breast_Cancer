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
        Schema::create('questions__c_s', function (Blueprint $table) {



            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('criterion_id');
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('criterion_id')->references('id')->on('criteria')->onDelete('cascade');

        });
    }

    /**23
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions__c_s');
    }
};
