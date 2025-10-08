<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usagers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('profession');
            $table->string('identifiant')->unique();
            $table->text('adresse');
            $table->string('telephone');
            $table->string('quartier');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usagers');
    }
};