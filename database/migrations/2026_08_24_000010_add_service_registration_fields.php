<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('SERVICE', function (Blueprint $table): void {
            $table->string('batiment', 100)->nullable()->after('type_service');
            $table->string('etage', 50)->nullable()->after('batiment');
            $table->string('chef_prenom', 100)->nullable()->after('email');
            $table->string('chef_nom', 100)->nullable()->after('chef_prenom');
            $table->string('mot_de_passe')->nullable()->after('chef_nom');
        });
    }

    public function down(): void
    {
        Schema::table('SERVICE', function (Blueprint $table): void {
            $table->dropColumn(['batiment', 'etage', 'chef_prenom', 'chef_nom', 'mot_de_passe']);
        });
    }
};