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
        if (! Schema::hasTable('ROLE') || ! Schema::hasTable('UTILISATEUR')) {
            return;
        }

        DB::table('ROLE')->updateOrInsert(
            ['id_role' => 'role-super-admin'],
            ['libelle_role' => 'super-administrateur']
        );
        DB::table('UTILISATEUR')->updateOrInsert(
            ['email' => 'superadmin@healthpass.test'],
            [
                'id_user' => 'user-super-admin-demo',
                'nom' => 'Administrateur',
                'prenom' => 'Super',
                'mot_de_passe' => Hash::make('SuperAdmin@12345'),
                'id_role' => 'role-super-admin',
                'id_etablissement' => null,
            ]
        );
    }

    public function down(): void
    {
        DB::table('UTILISATEUR')->where('id_user', 'user-super-admin-demo')->delete();
        DB::table('ROLE')->where('id_role', 'role-super-admin')->delete();
    }
};
