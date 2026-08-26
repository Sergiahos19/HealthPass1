<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('PATIENT')) {
            Schema::create('PATIENT', function (Blueprint $table): void {
                $table->string('id_patient', 42)->primary();
                $table->string('npi', 42)->nullable()->unique();
                $table->string('nom', 100)->nullable();
                $table->string('prenom', 100)->nullable();
                $table->string('sexe', 20)->nullable();
                $table->date('date_naissance')->nullable();
                $table->string('email')->nullable()->unique();
                $table->string('telephone', 30)->nullable();
                $table->string('empreinte_digitale')->nullable();
                $table->string('id_etablissement', 42)->nullable();
                $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT');
            });
        }

        if (! Schema::hasTable('DOCTEUR')) {
            Schema::create('DOCTEUR', function (Blueprint $table): void {
                $table->string('id_docteur', 42)->primary();
                $table->string('nom', 100)->nullable();
                $table->string('prenom', 100)->nullable();
                $table->string('specialite', 100)->nullable();
                $table->string('telephone', 30)->nullable();
                $table->string('email')->nullable();
                $table->string('mot_de_passe')->nullable();
                $table->string('id_etablissement', 42);
                $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT');
            });
        }

        if (Schema::hasColumn('PATIENT', 'id_etablissement')) {
            return;
        }

        Schema::table('PATIENT', function (Blueprint $table): void {
            $table->string('id_etablissement', 42)->nullable()->after('empreinte_digitale');
            $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT');
            $table->index('id_etablissement');
        });
    }

    public function down(): void
    {
        Schema::table('PATIENT', function (Blueprint $table): void {
            $table->dropForeign(['id_etablissement']);
            $table->dropIndex(['id_etablissement']);
            $table->dropColumn('id_etablissement');
        });
    }
};
