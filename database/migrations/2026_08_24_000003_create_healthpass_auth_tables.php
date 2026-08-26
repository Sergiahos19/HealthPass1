<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ETABLISSEMENT', function (Blueprint $table): void {
            $table->string('id_etablissement', 42)->primary();
            $table->string('nom_etablissement', 150);
            $table->string('adresse', 255);
            $table->string('telephone', 30)->nullable();
            $table->string('email_etablissement')->nullable();
            $table->string('numero_ifu', 30)->unique();
            $table->boolean('est_approuve')->default(false);
        });

        Schema::create('ROLE', function (Blueprint $table): void {
            $table->string('id_role', 42)->primary();
            $table->string('libelle_role', 42)->unique();
        });

        Schema::create('UTILISATEUR', function (Blueprint $table): void {
            $table->string('id_user', 42)->primary();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->string('id_role', 42);
            $table->string('id_etablissement', 42)->nullable();
            $table->foreign('id_role')->references('id_role')->on('ROLE');
            $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT');
        });

        DB::table('ROLE')->insert([
            ['id_role' => 'role-admin', 'libelle_role' => 'administrateur'],
            ['id_role' => 'role-service', 'libelle_role' => 'service'],
        ]);

        DB::table('ETABLISSEMENT')->insert([
            'id_etablissement' => 'etab-demo',
            'nom_etablissement' => 'Etablissement de demonstration',
            'adresse' => 'Cotonou',
            'email_etablissement' => 'contact@healthpass.test',
            'numero_ifu' => 'IFU-DEMO-001',
            'est_approuve' => true,
        ]);

        DB::table('UTILISATEUR')->insert([
            'id_user' => 'user-admin-demo',
            'nom' => 'Administrateur',
            'prenom' => 'Demo',
            'email' => 'admin@healthpass.test',
            'mot_de_passe' => Hash::make('Admin@12345'),
            'id_role' => 'role-admin',
            'id_etablissement' => 'etab-demo',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('UTILISATEUR');
        Schema::dropIfExists('ROLE');
        Schema::dropIfExists('ETABLISSEMENT');
    }
};
