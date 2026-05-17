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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('statut', ['brouillon', 'envoye', 'accepte', 'refuse'])->default('brouillon');
            $table->date('date_creation');
            $table->date('date_validite');
            $table->decimal('remise_globale', 5, 2)->default(0);
            $table->decimal('montant_ht', 10, 2)->default(0);
            $table->decimal('tva', 5, 2)->default(20);
            $table->decimal('montant_ttc', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
