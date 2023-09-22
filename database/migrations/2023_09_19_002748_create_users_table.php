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
            $table->increments('id')->unsigned();
            $table->string('username');
            $table->string('password');
            $table->string('last_login');
            $table->boolean('is_active');
            $table->integer('role')->unsigned()->default(1);
            $table->timestamps();

            $table->foreign('role')->references('id')->on('roles');
            
            $table->index(['username']);
            $table->index(['last_login']);
            $table->index(['is_active']);
            $table->index(['created_at']);
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
