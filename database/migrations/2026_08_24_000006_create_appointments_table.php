<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('RENDEZ_VOUS', function (Blueprint $table): void {
            $table->string('id_rendez_vous', 42)->primary();
            $table->string('id_patient', 42);
            $table->string('id_docteur', 42);
            $table->string('id_etablissement', 42);
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->string('motif', 150)->nullable();
            $table->string('statut', 42)->default('Planifié');
            $table->timestamps();

            $table->foreign('id_patient')->references('id_patient')->on('PATIENT')->cascadeOnDelete();
            $table->foreign('id_docteur')->references('id_docteur')->on('DOCTEUR')->cascadeOnDelete();
            $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT')->cascadeOnDelete();
            $table->index(['id_etablissement', 'date_rdv']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('RENDEZ_VOUS');
    }
};