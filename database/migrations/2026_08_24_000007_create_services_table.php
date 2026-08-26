<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('SERVICE', function (Blueprint $table): void {
            $table->string('id_service', 42)->primary();
            $table->string('nom_service', 100);
            $table->string('type_service', 100)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('id_etablissement', 42);
            $table->foreign('id_etablissement')->references('id_etablissement')->on('ETABLISSEMENT')->cascadeOnDelete();
            $table->index('id_etablissement');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SERVICE');
    }
};