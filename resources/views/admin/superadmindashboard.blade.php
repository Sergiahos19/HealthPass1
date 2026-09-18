@extends('layouts.superadmin')

@section('title', 'Administration globale - HealthPass')

@section('content')
<div class="mx-auto max-w-7xl space-y-8 p-6 lg:p-10">
    <header>
        <p class="text-sm font-semibold uppercase tracking-widest text-primary">Super administration</p>
        <h2 class="mt-2 text-3xl font-bold text-on-surface">Pilotage global de HealthPass</h2>
        <p class="mt-2 text-on-surface-variant">Données issues en temps réel des tables du système.</p>
    </header>

    @if ($section === 'dashboard')
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([['Instance HealthPass', 'etablissements', 'domain'], ['Utilisateurs', 'utilisateurs', 'manage_accounts'], ['Patients', 'patients', 'group'], ['Médecins', 'medecins', 'stethoscope'], ['Services', 'services', 'medical_services'], ['Rendez-vous', 'rendez_vous', 'event'], ['Consultations', 'consultations', 'clinical_notes']] as [$label, $key, $icon])
                <div class="rounded-2xl border border-outline-variant bg-white p-5 shadow-sm"><span class="material-symbols-outlined text-3xl text-primary">{{ $icon }}</span><p class="mt-4 text-sm text-on-surface-variant">{{ $label }}</p><p class="mt-1 text-3xl font-bold">{{ $superAdminCounts[$key] }}</p></div>
            @endforeach
        </section>
        <section class="rounded-2xl border border-outline-variant bg-white p-6">
            <h3 class="text-xl font-bold">Accès rapides</h3>
            <div class="mt-4 flex flex-wrap gap-3">
                @foreach ([['etablissements', 'Configurer l’instance'], ['utilisateurs', 'Gérer les utilisateurs'], ['patients', 'Consulter les patients'], ['audit', 'Journal d’activité']] as [$key, $label])
                    <a href="{{ route('admin.dashboard', ['section' => $key]) }}" class="rounded-lg border border-primary px-4 py-2 text-sm font-semibold text-primary hover:bg-primary hover:text-white">{{ $label }}</a>
                @endforeach
            </div>
        </section>
    @elseif ($section === 'etablissements')
        @include('admin.partials.superadmin-table', ['title' => 'Configuration de l’instance', 'items' => $superAdminData['etablissements'], 'columns' => ['nom_etablissement', 'email_etablissement', 'adresse', 'est_approuve']])
    @elseif ($section === 'utilisateurs' || $section === 'audit')
        @include('admin.partials.superadmin-table', ['title' => $section === 'audit' ? 'Journal d’activité des comptes' : 'Utilisateurs et personnel', 'items' => $superAdminData['utilisateurs'], 'columns' => ['prenom', 'nom', 'email', 'libelle_role']])
    @elseif ($section === 'patients')
        @include('admin.partials.superadmin-table', ['title' => 'Patients de l’instance', 'items' => $superAdminData['patients'], 'columns' => ['prenom', 'nom', 'email', 'telephone', 'npi']])
    @elseif ($section === 'parametres')
        <section class="rounded-2xl border border-outline-variant bg-white p-6"><h3 class="text-2xl font-bold">Paramètres système</h3><p class="mt-2 text-on-surface-variant">Les paramètres globaux sont consultables depuis cet espace. Les données opérationnelles sont gérées dans l’instance HealthPass.</p><div class="mt-6 rounded-xl bg-surface-container-low p-4 text-sm">Mode : {{ config('app.env') }} · Application : {{ config('app.name') }}</div></section>
    @else
        <section class="rounded-2xl border border-outline-variant bg-white p-8"><h3 class="text-2xl font-bold">Page non disponible</h3><p class="mt-2 text-on-surface-variant">Cet onglet ne correspond à aucune fonctionnalité active.</p></section>
    @endif
</div>
@endsection
