<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('UTILISATEUR')->where('id_role', 'role-super-admin')->delete();
        DB::table('ROLE')->where('id_role', 'role-super-admin')->delete();
    }

    public function down(): void
    {
        DB::table('ROLE')->insertOrIgnore([
            'id_role' => 'role-super-admin',
            'libelle_role' => 'super-administrateur',
        ]);
    }
};
