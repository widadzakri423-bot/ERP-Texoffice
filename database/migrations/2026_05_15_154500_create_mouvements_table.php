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
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->enum('type', ['entree', 'sortie']);
            $table->decimal('quantite', 10, 2);
            $table->decimal('prix_unitaire', 10, 2)->nullable(); // utile pour les entrées (coût d'achat)
            $table->foreignId('devis_id')->nullable()->constrained('devis')->onDelete('set null'); // lié si sortie devis
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // qui a fait le mouvement
            $table->string('motif')->nullable();
            $table->date('date_mouvement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements');
    }
};
