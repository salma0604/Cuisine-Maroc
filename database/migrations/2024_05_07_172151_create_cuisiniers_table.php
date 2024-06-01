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
        Schema::create('cuisiniers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('ville');
            $table->string('tele');
            $table->string('email')->unique();
            $table->string('disponibilite');
            $table->string('prix')->nullable();
            $table->string('lieuTravail');
            $table->unsignedBigInteger('IdUtilisateur');
            $table->foreign('IdUtilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuisiniers');
    }
};
