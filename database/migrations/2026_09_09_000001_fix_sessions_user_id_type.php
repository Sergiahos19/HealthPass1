<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Les identifiants de UTILISATEUR sont des chaînes (ex: user-doctor-demo).
 * La colonne sessions.user_id créée en entier faisait échouer silencieusement
 * l'écriture de la session après connexion : l'utilisateur était renvoyé vers
 * /login sans message d'erreur.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('sessions')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `sessions` MODIFY `user_id` VARCHAR(191) NULL');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('sessions')) {
            return;
        }

        DB::table('sessions')->truncate();
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `sessions` MODIFY `user_id` BIGINT UNSIGNED NULL');
        }
    }
};
