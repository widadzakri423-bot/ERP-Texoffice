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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('designation');
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->enum('etat', ['disponible', 'en_maintenance', 'hors_service', 'occupe'])->default('disponible');
            $table->date('date_acquisition')->nullable();
            $table->decimal('cout_heure', 10, 2)->default(0); // coût d'utilisation estimé
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
