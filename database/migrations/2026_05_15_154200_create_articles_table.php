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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('designation');
            $table->string('categorie')->nullable();
            $table->string('unite')->default('unité');
            $table->decimal('quantite_stock', 10, 2)->default(0);
            $table->decimal('seuil_minimum', 10, 2)->default(0); // alerte stock bas
            $table->decimal('prix_unitaire', 10, 2)->default(0);
            $table->string('emplacement')->nullable(); // localisation en magasin
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
