<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('PATIENT', function (Blueprint $table): void {
            $table->decimal('taille', 4, 2)->nullable()->after('date_naissance');
            $table->decimal('poids', 5, 1)->nullable()->after('taille');
            $table->string('groupe_sanguin', 3)->nullable()->after('poids');
            $table->string('contact_urgence_nom', 150)->nullable()->after('id_etablissement');
            $table->string('contact_urgence_lien', 80)->nullable()->after('contact_urgence_nom');
            $table->string('contact_urgence_telephone', 30)->nullable()->after('contact_urgence_lien');
            $table->string('contact_urgence_email')->nullable()->after('contact_urgence_telephone');
            $table->text('contact_urgence_adresse')->nullable()->after('contact_urgence_email');
        });
    }

    public function down(): void
    {
        Schema::table('PATIENT', function (Blueprint $table): void {
            $table->dropColumn([
                'taille', 'poids', 'groupe_sanguin', 'contact_urgence_nom', 'contact_urgence_lien',
                'contact_urgence_telephone', 'contact_urgence_email', 'contact_urgence_adresse',
            ]);
        });
    }
};
