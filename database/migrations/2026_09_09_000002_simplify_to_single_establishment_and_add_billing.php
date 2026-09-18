<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * HealthPass now runs one installation.  ETABLISSEMENT is kept as the
         * installation profile for backwards compatibility with existing
         * records, but it is no longer a tenant boundary.
         */
        $establishmentId = 'etab-demo';

        if (Schema::hasTable('ETABLISSEMENT')) {
            $existingId = DB::table('ETABLISSEMENT')->orderBy('id_etablissement')->value('id_etablissement');

            if ($existingId) {
                $establishmentId = (string) $existingId;
            } else {
                DB::table('ETABLISSEMENT')->insert([
                    'id_etablissement' => $establishmentId,
                    'nom_etablissement' => 'HealthPass',
                    'adresse' => '',
                    'numero_ifu' => 'HEALTHPASS-001',
                    'est_approuve' => true,
                ]);
            }

            foreach ([
                'UTILISATEUR', 'PATIENT', 'DOCTEUR', 'SERVICE', 'RENDEZ_VOUS',
                'SALLE_ATTENTE', 'CONSULTATION', 'ANALYSE', 'PRESCRIPTION',
            ] as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'id_etablissement')) {
                    DB::table($table)->whereNotNull('id_etablissement')->update([
                        'id_etablissement' => $establishmentId,
                    ]);
                }
            }

            DB::table('ETABLISSEMENT')->where('id_etablissement', '<>', $establishmentId)->delete();
        }

        if (Schema::hasTable('ROLE')) {
            DB::table('ROLE')->insertOrIgnore([
                ['id_role' => 'role-admin', 'libelle_role' => 'administrateur'],
                ['id_role' => 'role-super-admin', 'libelle_role' => 'super-administrateur'],
                ['id_role' => 'role-doctor', 'libelle_role' => 'medecin'],
                ['id_role' => 'role-cashier', 'libelle_role' => 'caissier / facturation'],
                ['id_role' => 'role-patient', 'libelle_role' => 'patient'],
            ]);
        }

        if (Schema::hasTable('PATIENT') && ! Schema::hasColumn('PATIENT', 'id_user')) {
            Schema::table('PATIENT', function (Blueprint $table): void {
                $table->string('id_user', 42)->nullable()->unique()->after('id_patient');
                $table->foreign('id_user')->references('id_user')->on('UTILISATEUR')->nullOnDelete();
            });
        }

        if (Schema::hasTable('FACTURE')) {
            return;
        }

        Schema::create('FACTURE', function (Blueprint $table): void {
            $table->string('id_facture', 42)->primary();
            $table->string('numero_facture', 60)->unique();
            $table->string('id_patient', 42);
            $table->string('id_consultation', 42)->nullable();
            $table->string('id_caissier', 42)->nullable();
            $table->decimal('montant', 12, 2);
            $table->string('devise', 3)->default('XOF');
            $table->string('statut', 30)->default('emise');
            $table->string('mode_paiement', 40)->nullable();
            $table->date('date_facture');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('id_patient')->references('id_patient')->on('PATIENT')->cascadeOnDelete();
            $table->foreign('id_consultation')->references('id_consultation')->on('CONSULTATION')->nullOnDelete();
            $table->foreign('id_caissier')->references('id_user')->on('UTILISATEUR')->nullOnDelete();
            $table->index(['id_patient', 'date_facture']);
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FACTURE');

        if (Schema::hasTable('PATIENT') && Schema::hasColumn('PATIENT', 'id_user')) {
            Schema::table('PATIENT', function (Blueprint $table): void {
                $table->dropForeign(['id_user']);
                $table->dropUnique(['id_user']);
                $table->dropColumn('id_user');
            });
        }
    }
};
