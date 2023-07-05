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
        Schema::create('unknowns', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->string('translate');
            $table->integer('repetition');
            $table->string('root');
            $table->string('level');
            $table->string('difficultyRate');
            $table->string('type');
            $table->integer('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unknowns');
    }
};
