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
        Schema::table('UTILISATEUR', function (Blueprint $table): void {
            $table->string('id_service', 42)->nullable()->after('id_etablissement');
            $table->foreign('id_service')->references('id_service')->on('SERVICE')->nullOnDelete();
            $table->index('id_service');
        });

        $serviceId = 'service-demo';
        DB::table('SERVICE')->insertOrIgnore([
            'id_service' => $serviceId,
            'nom_service' => 'Laboratoire Central',
            'type_service' => 'Laboratoire',
            'telephone' => '+229 21 00 00 00',
            'email' => 'laboratoire@healthpass.test',
            'id_etablissement' => 'etab-demo',
            'batiment' => 'Pavillon A',
            'etage' => '1er étage',
            'chef_prenom' => 'Sophie',
            'chef_nom' => 'Mensah',
            'mot_de_passe' => Hash::make('Service@12345'),
        ]);
        DB::table('UTILISATEUR')->insertOrIgnore([
            'id_user' => 'user-service-demo',
            'nom' => 'Mensah',
            'prenom' => 'Sophie',
            'email' => 'laboratoire@healthpass.test',
            'mot_de_passe' => Hash::make('Service@12345'),
            'id_role' => 'role-service',
            'id_etablissement' => 'etab-demo',
            'id_service' => $serviceId,
        ]);
    }

    public function down(): void
    {
        DB::table('UTILISATEUR')->where('id_user', 'user-service-demo')->delete();
        DB::table('SERVICE')->where('id_service', 'service-demo')->delete();
        Schema::table('UTILISATEUR', function (Blueprint $table): void {
            $table->dropForeign(['id_service']);
            $table->dropIndex(['id_service']);
            $table->dropColumn('id_service');
        });
    }
};