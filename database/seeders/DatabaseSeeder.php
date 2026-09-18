<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $establishmentId = DB::table('ETABLISSEMENT')->orderBy('id_etablissement')->value('id_etablissement') ?: 'etab-demo';

        DB::table('ROLE')->insertOrIgnore([
            'id_role' => 'role-doctor',
            'libelle_role' => 'medecin',
        ]);
        DB::table('ROLE')->insertOrIgnore([
            'id_role' => 'role-service',
            'libelle_role' => 'service',
        ]);
        DB::table('ROLE')->insertOrIgnore([
            'id_role' => 'role-cashier',
            'libelle_role' => 'caissier / facturation',
        ]);
        DB::table('ROLE')->insertOrIgnore([
            'id_role' => 'role-patient',
            'libelle_role' => 'patient',
        ]);
        DB::table('UTILISATEUR')->updateOrInsert(
            ['email' => 'caissier@healthpass.test'],
            [
                'id_user' => 'user-cashier-demo',
                'nom' => 'Caissier',
                'prenom' => 'Demo',
                'mot_de_passe' => Hash::make('Caissier@12345'),
                'id_role' => 'role-cashier',
                'id_etablissement' => $establishmentId,
            ]
        );

        $serviceData = [
            'nom_service' => 'Laboratoire Central',
            'type_service' => 'Laboratoire',
            'telephone' => '+229 21 00 00 00',
            'email' => 'laboratoire@healthpass.test',
            'id_etablissement' => $establishmentId,
            'batiment' => 'Pavillon A',
            'etage' => '1er étage',
            'chef_prenom' => '',
            'chef_nom' => 'Kelly',
            'mot_de_passe' => Hash::make('Service@12345'),
        ];
        if (Schema::hasColumn('SERVICE', 'est_approuve')) {
            $serviceData['est_approuve'] = true;
        }
        DB::table('SERVICE')->updateOrInsert(
            ['id_service' => 'service-demo'],
            $serviceData
        );
        DB::table('UTILISATEUR')->updateOrInsert(
            ['id_user' => 'user-service-demo'],
            [
                'nom' => 'Kelly',
                'prenom' => '',
                'email' => 'laboratoire@healthpass.test',
                'mot_de_passe' => Hash::make('Service@12345'),
                'id_role' => 'role-service',
                'id_etablissement' => $establishmentId,
                'id_service' => 'service-demo',
            ]
        );

        DB::table('UTILISATEUR')->where('id_user', 'user-admin-demo')->update([
            'email' => 'admin@healthpass.test',
            'nom' => 'Sergio.Kelly',
            'prenom' => 'Admin',
        ]);

        DB::table('UTILISATEUR')->updateOrInsert(
            ['email' => 'medecin@healthpass.test'],
            [
                'id_user' => 'user-doctor-demo',
                'nom' => 'Exaucé',
                'prenom' => 'Sergio',
                'mot_de_passe' => Hash::make('Medecin@12345'),
                'id_role' => 'role-doctor',
                'id_etablissement' => $establishmentId,
            ]
        );

        $userId = DB::table('UTILISATEUR')
            ->where('email', 'medecin@healthpass.test')
            ->value('id_user');

        DB::table('DOCTEUR')->updateOrInsert(
            ['email' => 'medecin@healthpass.test'],
            [
                'id_docteur' => 'doctor-demo',
                'id_user' => $userId,
                'nom' => 'Exaucé',
                'prenom' => 'Sergio',
                'specialite' => 'Médecine Générale',
                'telephone' => '+229 97 00 00 00',
                'mot_de_passe' => Hash::make('Medecin@12345'),
                'id_etablissement' => $establishmentId,
                'est_approuve' => true,
            ]
        );

        $patient = [
            'id_patient' => 'patient-sergio-exauce-demo',
            'npi' => 'NPI-BJ-DEMO-0001',
            'nom' => 'SERGIO',
            'prenom' => 'Exaucé',
            'sexe' => 'M',
            'date_naissance' => '1992-05-14',
            'email' => 'sergioahossi19@gmail.com',
            'telephone' => '+229 97 45 18 62',
            'id_etablissement' => $establishmentId,
        ];

        if (Schema::hasColumn('PATIENT', 'taille')) {
            $patient['taille'] = 1.74;
            $patient['poids'] = 72.0;
            $patient['groupe_sanguin'] = 'O+';
            $patient['contact_urgence_nom'] = 'Afi Sergio';
            $patient['contact_urgence_lien'] = 'Sœur';
            $patient['contact_urgence_telephone'] = '+229 96 32 74 11';
            $patient['contact_urgence_email'] = 'afi.sergio@healthpass.test';
            $patient['contact_urgence_adresse'] = 'Abomey-Calavi, Bénin';
        }

        DB::table('PATIENT')->updateOrInsert(
            ['id_patient' => $patient['id_patient']],
            $patient
        );

        if (Schema::hasColumn('PATIENT', 'id_user')) {
            DB::table('UTILISATEUR')->updateOrInsert(
                ['email' => $patient['email']],
                [
                    'id_user' => 'user-patient-demo',
                    'nom' => $patient['nom'],
                    'prenom' => $patient['prenom'],
                    'mot_de_passe' => Hash::make('Patient@12345'),
                    'id_role' => 'role-patient',
                    'id_etablissement' => $establishmentId,
                ]
            );
            DB::table('PATIENT')->where('id_patient', $patient['id_patient'])->update([
                'id_user' => DB::table('UTILISATEUR')->where('email', $patient['email'])->value('id_user'),
            ]);
        }

        if (Schema::hasTable('RENDEZ_VOUS')) {
            DB::table('RENDEZ_VOUS')->updateOrInsert(
                ['id_rendez_vous' => 'rdv-sergio-exauce-demo'],
                [
                    'id_patient' => $patient['id_patient'],
                    'id_docteur' => 'doctor-demo',
                    'id_etablissement' => $establishmentId,
                    'date_rdv' => today(),
                    'heure_rdv' => '14:00',
                    'motif' => 'Consultation de démonstration',
                    'statut' => 'Planifié',
                ]
            );
        }

    }
}
