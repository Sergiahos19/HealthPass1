<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('SERVICE', function (Blueprint $table): void {
            if (! Schema::hasColumn('SERVICE', 'est_approuve')) {
                $table->boolean('est_approuve')->default(false)->after('id_etablissement');
            }
            if (! Schema::hasColumn('SERVICE', 'est_actif')) {
                $table->boolean('est_actif')->default(false)->after('est_approuve');
            }
        });

        if (Schema::hasTable('SERVICE')) {
            DB::table('SERVICE')->whereNull('est_approuve')->update(['est_approuve' => false]);
            DB::table('SERVICE')->whereNull('est_actif')->update(['est_actif' => false]);
        }
    }

    public function down(): void
    {
        Schema::table('SERVICE', function (Blueprint $table): void {
            if (Schema::hasColumn('SERVICE', 'est_actif')) {
                $table->dropColumn('est_actif');
            }
            if (Schema::hasColumn('SERVICE', 'est_approuve')) {
                $table->dropColumn('est_approuve');
            }
        });
    }
};
