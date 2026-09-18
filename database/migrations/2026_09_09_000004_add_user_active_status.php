<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('UTILISATEUR') && ! Schema::hasColumn('UTILISATEUR', 'est_actif')) {
            Schema::table('UTILISATEUR', function (Blueprint $table): void {
                $table->boolean('est_actif')->default(true);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('UTILISATEUR') && Schema::hasColumn('UTILISATEUR', 'est_actif')) {
            Schema::table('UTILISATEUR', function (Blueprint $table): void {
                $table->dropColumn('est_actif');
            });
        }
    }
};
