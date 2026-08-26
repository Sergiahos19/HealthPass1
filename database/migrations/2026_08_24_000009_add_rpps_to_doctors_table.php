<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('DOCTEUR', function (Blueprint $table): void {
            $table->string('rpps_number', 20)->nullable()->unique()->after('specialite');
        });
    }

    public function down(): void
    {
        Schema::table('DOCTEUR', function (Blueprint $table): void {
            $table->dropUnique(['rpps_number']);
            $table->dropColumn('rpps_number');
        });
    }
};