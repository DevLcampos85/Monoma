<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidatos', function (Blueprint $table) {

            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('source');
            $table->integer('owner')->unsigned()->default(1);
            $table->integer('created_by')->unsigned()->default(1);
            $table->timestamps();

            $table->foreign('owner')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');

            $table->index(['name']);
            $table->index(['source']);
            $table->index(['created_at']);

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};