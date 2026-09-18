<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('FORMAT')) {
            Schema::create('FORMAT', function (Blueprint $table): void {
                $table->string('id_format', 42)->primary();
                $table->string('libelle_format', 150);
                $table->string('type_examen', 100)->nullable();
                $table->text('observation')->nullable();
                $table->string('id_service', 42);
                $table->foreign('id_service')->references('id_service')->on('SERVICE')->cascadeOnDelete();
                $table->index('id_service');
            });
        }

        if (! Schema::hasTable('DEMANDE_ANALYSE')) {
            Schema::create('DEMANDE_ANALYSE', function (Blueprint $table): void {
                $table->string('id_demande', 42)->primary();
                $table->string('id_patient', 42);
                $table->string('id_docteur', 42)->nullable();
                $table->string('id_service', 42);
                $table->string('id_format', 42);
                $table->string('priorite', 20)->default('Normale');
                $table->string('statut', 30)->default('En attente');
                $table->text('prescription')->nullable();
                $table->text('observation')->nullable();
                $table->text('resultat')->nullable();
                $table->string('fichier_resultat')->nullable();
                $table->timestamp('demande_at');
                $table->timestamp('traitee_at')->nullable();
                $table->timestamps();
                $table->foreign('id_patient')->references('id_patient')->on('PATIENT')->cascadeOnDelete();
                $table->foreign('id_docteur')->references('id_docteur')->on('DOCTEUR')->nullOnDelete();
                $table->foreign('id_service')->references('id_service')->on('SERVICE')->cascadeOnDelete();
                $table->foreign('id_format')->references('id_format')->on('FORMAT')->cascadeOnDelete();
                $table->index(['id_service', 'statut', 'demande_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('DEMANDE_ANALYSE');
        Schema::dropIfExists('FORMAT');
    }
};
