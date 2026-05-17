<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('machines')->onDelete('cascade');
            $table->date('date_intervention');
            $table->text('description');
            $table->decimal('cout', 10, 2)->default(0);
            $table->enum('type', ['preventive', 'corrective', 'revision'])->default('corrective');
            $table->string('technicien')->nullable();
            $table->text('pieces_remplacees')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};