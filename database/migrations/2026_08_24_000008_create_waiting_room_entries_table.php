<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('SALLE_ATTENTE', function (Blueprint $table): void {
            $table->string('id_attente', 42)->primary();
            $table->string('id_patient', 42);
            $table->string('id_etablissement', 42);
            $table->timestamp('arrivee_at');
            $table->string('statut', 42)->default('En attente');
            $table->foreign('id_patient')->references('id_patient')->on('PATIENT')->cascadeOnDelete();
            $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT')->cascadeOnDelete();
            $table->index(['id_etablissement', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SALLE_ATTENTE');
    }
};