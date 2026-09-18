<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('UTILISATEUR') || Schema::hasColumn('UTILISATEUR', 'doit_changer_mot_de_passe')) {
            return;
        }

        Schema::table('UTILISATEUR', function (Blueprint $table): void {
            $table->boolean('doit_changer_mot_de_passe')->default(false);
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('UTILISATEUR') && Schema::hasColumn('UTILISATEUR', 'doit_changer_mot_de_passe')) {
            Schema::table('UTILISATEUR', function (Blueprint $table): void {
                $table->dropColumn('doit_changer_mot_de_passe');
            });
        }
    }
};
