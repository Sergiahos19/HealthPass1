<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>HealthPass - Tableau de Bord Administration</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            background: #f8fafc;
        }

        body {
            overflow-x: hidden;
        }

        .dashboard-card {
            box-shadow: 0 8px 24px rgba(15, 42, 67, 0.06);
            transition: box-shadow 180ms ease, transform 180ms ease;
        }

        .dashboard-card:hover {
            box-shadow: 0 12px 30px rgba(15, 42, 67, 0.1);
            transform: translateY(-2px);
        }

        @media (max-width: 767px) {
            .dashboard-card:hover {
                transform: none;
            }
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="hp-workspace hp-workspace-admin bg-fond-page text-on-surface font-corps-standard min-h-screen flex">

<!-- SideNavBar -->
<aside class="hp-admin-sidebar fixed left-0 top-0 z-50 hidden h-full w-64 flex-col md:flex">
    <div class="hp-admin-brand">
        <span class="hp-admin-brand__mark"><span class="material-symbols-outlined">health_and_safety</span></span>
        <span><strong>HealthPass</strong><small>Administration</small></span>
    </div>
    <div class="hp-admin-context">
        <span class="hp-admin-context__avatar">{{ strtoupper(substr($user->prenom ?? 'A', 0, 1).substr($user->nom ?? 'D', 0, 1)) }}</span>
        <span class="min-w-0"><strong>{{ $user->prenom ?? 'Admin' }} {{ $user->nom ?? '' }}</strong><small>{{ $etablissement?->nom_etablissement ?? 'Établissement' }}</small></span>
    </div>
    <p class="hp-admin-nav-label">Espace de gestion</p>
    <nav class="flex-1 space-y-2 px-2">
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => ! $section, 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section]) href="{{ route('admin.dashboard') }}" @if (! $section) aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">dashboard</span>
            <span class="font-label-fort text-label-fort">Tableau de bord</span>
        </a>
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'patients', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'patients']) href="{{ route('admin.dashboard', ['section' => 'patients']) }}" @if ($section === 'patients') aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">group</span>
            <span class="font-label-fort text-label-fort">Patients</span>
        </a>
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'rendez-vous', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'rendez-vous']) href="{{ route('admin.dashboard', ['section' => 'rendez-vous']) }}" @if ($section === 'rendez-vous') aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">event</span>
            <span class="font-label-fort text-label-fort">Rendez-vous</span>
        </a>
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'services', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'services']) href="{{ route('admin.dashboard', ['section' => 'services']) }}" @if ($section === 'services') aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">badge</span>
            <span class="font-label-fort text-label-fort">Services</span>
        </a>
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'medecins', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'medecins']) href="{{ route('admin.dashboard', ['section' => 'medecins']) }}" @if ($section === 'medecins') aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">stethoscope</span>
            <span class="font-label-fort text-label-fort">Médecins</span>
        </a>
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'carnets', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'carnets']) href="{{ route('admin.dashboard', ['section' => 'carnets']) }}" @if ($section === 'carnets') aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">clinical_notes</span>
            <span class="font-label-fort text-label-fort">Carnets médicaux</span>
        </a>
        @if ($user->isAdministrator())
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'utilisateurs', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'utilisateurs']) href="{{ route('admin.dashboard', ['section' => 'utilisateurs']) }}">
            <span class="material-symbols-outlined mr-3">manage_accounts</span><span class="font-label-fort text-label-fort">Utilisateurs</span>
        </a>
        @endif
        <a @class(['flex items-center px-4 py-3 rounded-lg mx-2 duration-200', 'bg-primary-container dark:bg-primary text-on-primary-container dark:text-on-primary opacity-80' => $section === 'parametres', 'text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-high dark:hover:bg-outline transition-all' => $section !== 'parametres']) href="{{ route('admin.dashboard', ['section' => 'parametres']) }}" @if ($section === 'parametres') aria-current="page" @endif>
            <span class="material-symbols-outlined mr-3">settings</span>
            <span class="font-label-fort text-label-fort">Paramètres</span>
        </a>
    </nav>
    <div class="px-2 mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="mx-2">
            @csrf
            <button class="flex w-full items-center rounded-lg px-4 py-3 text-left text-on-surface-variant transition-all hover:bg-surface-container-high dark:text-outline-variant dark:hover:bg-outline" type="submit">
                <span class="material-symbols-outlined mr-3">logout</span>
                <span class="font-label-fort text-label-fort">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<!-- Main Content -->
<main class="flex min-h-screen flex-1 flex-col md:ml-64">
    <!-- TopAppBar -->
    @if (! $section)
        <header class="hp-admin-topbar sticky top-0 z-40 flex min-h-16 w-full items-center justify-between px-4 sm:px-marge-page">
            <div class="flex min-w-0 items-center gap-3">
                <span class="hp-admin-topbar__icon material-symbols-outlined">shield_lock</span>
                <div><p class="hp-admin-topbar__eyebrow">Espace sécurisé</p><h2 class="truncate">Console administrative</h2></div>
            </div>
            <div class="ml-4 flex shrink-0 items-center space-x-1 sm:space-x-4">
                <button aria-label="Voir les notifications" class="rounded-full p-2 text-on-surface-variant transition-colors hover:bg-surface-container-low">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <span class="hp-admin-status"><i></i> Système opérationnel</span>
                <button aria-label="Ouvrir le profil" class="hp-admin-profile">{{ strtoupper(substr($user->prenom ?? 'A', 0, 1).substr($user->nom ?? 'D', 0, 1)) }}</button>
            </div>
        </header>
    @endif

    <div class="mx-auto w-full max-w-[1600px] flex-1 p-4 sm:p-marge-page lg:px-10">
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800" role="alert">
                <span class="material-symbols-outlined">error</span>{{ session('error') }}
            </div>
        @endif
        @if (! $section)
        <!-- Security Banner -->
        <div class="mb-8 flex items-start rounded-xl border border-alerte-critique bg-error-container bg-opacity-20 p-4 sm:mb-espacement-section">
            <span class="material-symbols-outlined text-alerte-critique mr-3 mt-1">warning</span>
            <div>
                <h3 class="font-label-fort text-label-fort text-alerte-critique mb-1">Rappel de Sécurité</h3>
                <p class="font-corps-dense text-corps-dense text-on-surface">Le personnel administratif n'a AUCUN accès aux données médicales confidentielles.</p>
            </div>
        </div>

        <!-- Page Header -->
        <header class="hp-admin-pagehead flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <p class="hp-admin-kicker">Vue d’ensemble · {{ now()->locale('fr')->translatedFormat('l d F') }}</p>
                <h1 class="font-titre-ecran text-titre-ecran text-on-surface mb-2">Bonjour, {{ $user->prenom ?? 'Administrateur' }}</h1>
                <p class="font-corps-standard text-corps-standard text-on-surface-variant">Voici l’activité de votre établissement aujourd’hui.</p>
            </div>
            <div class="flex items-center gap-3 bg-surface-container-lowest border border-outline-variant/60 rounded-full px-4 py-2 shadow-sm">
                <span class="material-symbols-outlined text-outline">calendar_today</span>
                <span class="font-label-fort text-label-fort text-on-surface">{{ now()->locale('fr')->translatedFormat('d F Y') }}</span>
            </div>
        </header>

        <!-- Section: Aperçu -->
        <section class="space-y-gouttiere mb-8">
            <h2 class="font-sous-titre text-sous-titre text-on-surface flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">monitoring</span>
                Aperçu
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-gouttiere">
                <!-- Metric Card 1 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/60 shadow-[0px_4px_12px_rgba(51,65,85,0.05)] hover:shadow-[0px_8px_20px_rgba(51,65,85,0.08)] transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary-container/30 rounded-full blur-xl group-hover:bg-primary-container/50 transition-colors"></div>
                    <div class="flex items-start justify-between mb-6 relative z-10">
                        <div class="w-12 h-12 rounded-full bg-surface-container text-primary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">event_available</span>
                        </div>
                        @if ($user->isAdministrator())
                        <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/60"><p class="text-xs uppercase tracking-wider text-on-surface-variant">Comptes utilisateurs</p><h3 class="mt-3 text-3xl font-bold">{{ $utilisateursCount }}</h3><a class="mt-2 inline-block text-sm text-primary" href="{{ route('admin.dashboard', ['section' => 'utilisateurs']) }}">Gérer →</a></div>
                        @endif
                        <span class="bg-tertiary-container/10 text-tertiary font-label-fort text-mention-legale px-3 py-1 rounded-full border border-tertiary/20 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                            Aujourd'hui
                        </span>
                    </div>
                    <div class="relative z-10">
                        <p class="font-corps-dense text-corps-dense text-on-surface-variant mb-1 uppercase tracking-wider">Rendez-vous du jour</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="font-titre-ecran text-titre-ecran text-on-surface">{{ count($rendezVous) }}</h3>
                            <span class="font-corps-dense text-corps-dense text-outline">/ 180 cap</span>
                        </div>
                    </div>
                </div>
                <!-- Metric Card 2 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/60 shadow-[0px_4px_12px_rgba(51,65,85,0.05)] hover:shadow-[0px_8px_20px_rgba(51,65,85,0.08)] transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-secondary-container/30 rounded-full blur-xl group-hover:bg-secondary-container/50 transition-colors"></div>
                    <div class="flex items-start justify-between mb-6 relative z-10">
                        <div class="w-12 h-12 rounded-full bg-secondary-fixed text-secondary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">patient_list</span>
                        </div>
                        <span class="bg-surface-container-high text-on-surface font-label-fort text-mention-legale px-3 py-1 rounded-full border border-outline-variant/30 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">horizontal_rule</span>
                            Dans l'établissement
                        </span>
                    </div>
                    <div class="relative z-10">
                        <p class="font-corps-dense text-corps-dense text-on-surface-variant mb-1 uppercase tracking-wider">Patients inscrits</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="font-titre-ecran text-titre-ecran text-on-surface">{{ number_format($patientsCount, 0, ',', ' ') }}</h3>
                        </div>
                    </div>
                </div>
                <!-- Metric Card 3 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/60 shadow-[0px_4px_12px_rgba(51,65,85,0.05)] hover:shadow-[0px_8px_20px_rgba(51,65,85,0.08)] transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-tertiary-container/20 rounded-full blur-xl group-hover:bg-tertiary-container/40 transition-colors"></div>
                    <div class="flex items-start justify-between mb-6 relative z-10">
                        <div class="w-12 h-12 rounded-full bg-tertiary-fixed text-tertiary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">stethoscope</span>
                        </div>
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-tertiary border-2 border-surface-container-lowest animate-pulse"></div>
                            <div class="w-6 h-6 rounded-full bg-tertiary border-2 border-surface-container-lowest animate-pulse delay-75"></div>
                            <div class="w-6 h-6 rounded-full bg-tertiary border-2 border-surface-container-lowest animate-pulse delay-150"></div>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="font-corps-dense text-corps-dense text-on-surface-variant mb-1 uppercase tracking-wider">Médecins actifs</p>
                        <div class="flex items-baseline gap-2">
                            <h3 class="font-titre-ecran text-titre-ecran text-on-surface">{{ $medecinsActifsCount ?? $medecinsCount }}</h3>
                            <span class="font-corps-dense text-corps-dense text-outline">approuvés</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Raccourcis -->
        <section class="space-y-gouttiere mb-8">
            <h2 class="font-sous-titre text-sous-titre text-on-surface flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">bolt</span>
                Raccourcis
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-gouttiere">
                <!-- Action: Inscrire un Patient -->
                <a href="{{ route('patients.create') }}" class="flex flex-col items-start justify-between h-40 p-6 bg-primary rounded-xl shadow-[0px_8px_20px_rgba(51,65,85,0.08)] hover:bg-primary-container hover:-translate-y-1 transition-all duration-300 group text-left relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-bl-full pointer-events-none"></div>
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-on-primary" style="font-variation-settings: 'FILL' 1;">person_add</span>
                    </div>
                    <h3 class="font-label-fort text-label-fort text-on-primary">Inscrire un Patient</h3>
                    <span class="material-symbols-outlined absolute bottom-6 right-6 text-on-primary/50 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">arrow_forward</span>
                </a>
                <!-- Action: Programmer un RDV -->
                <a href="{{ route('admin.dashboard', ['section' => 'rendez-vous']) }}" class="flex flex-col items-start justify-between h-40 p-6 bg-surface-container-lowest border border-outline-variant/60 rounded-xl shadow-[0px_4px_12px_rgba(51,65,85,0.05)] hover:shadow-[0px_8px_20px_rgba(51,65,85,0.08)] hover:border-secondary hover:-translate-y-1 transition-all duration-300 group text-left">
                    <div class="bg-surface-container p-2 rounded-lg mb-4 group-hover:bg-secondary-container transition-colors">
                        <span class="material-symbols-outlined text-secondary group-hover:text-on-secondary-container transition-colors">edit_calendar</span>
                    </div>
                    <div>
                        <h3 class="font-label-fort text-label-fort text-on-surface">Programmer un RDV</h3>
                        <p class="font-mention-legale text-mention-legale text-on-surface-variant mt-1">Accès planning centralisé</p>
                    </div>
                </a>
                <!-- Action: Ajouter un Docteur -->
            </div>
        </section>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Appointments List -->
            <div class="dashboard-card col-span-1 rounded-xl border border-bordure-douce bg-surface p-4 sm:p-padding-carte xl:col-span-2">
                <div class="flex justify-between items-center mb-6 border-b border-bordure-douce pb-4">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-primary mr-2">calendar_today</span>
                        <h3 class="font-sous-titre text-sous-titre text-on-surface">Rendez-vous du jour</h3>
                    </div>
                    <button class="text-primary font-label-fort text-label-fort hover:underline">Voir tout</button>
                </div>
                <div class="space-y-0">
                    @forelse ($rendezVous as $rendezVousItem)
                    <div class="flex items-center justify-between gap-3 border-b border-bordure-douce bg-fond-page p-3 sm:p-4">
                        <div class="flex min-w-0 items-center gap-3 sm:space-x-4">
                            <div class="w-11 shrink-0 text-center sm:w-12">
                                <span class="font-label-fort text-label-fort text-primary block">{{ \Illuminate\Support\Carbon::parse($rendezVousItem->heure_rdv)->format('H:i') }}</span>
                            </div>
                            <div class="w-10 h-10 bg-surface-container rounded-full flex items-center justify-center text-primary font-label-fort">RDV</div>
                            <div class="min-w-0">
                                <p class="font-label-fort text-label-fort text-on-surface">{{ $rendezVousItem->prenom }} {{ $rendezVousItem->nom }}</p>
                                <p class="font-corps-dense text-corps-dense text-on-surface-variant">{{ $rendezVousItem->motif ?: 'Rendez-vous' }}</p>
                            </div>
                        </div>
                        <div class="shrink-0 rounded-full bg-surface-container-high px-2 py-1 sm:px-3">
                            <span class="font-mention-legale text-mention-legale text-on-surface-variant">{{ $rendezVousItem->statut ?: 'À venir' }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="p-4 text-corps-dense text-on-surface-variant">Aucun rendez-vous aujourd'hui.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Patients -->
            <div class="dashboard-card col-span-1 rounded-xl border border-bordure-douce bg-surface p-4 sm:p-padding-carte">
                <div class="flex justify-between items-center mb-6 border-b border-bordure-douce pb-4">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-primary mr-2">recent_actors</span>
                        <h3 class="font-sous-titre text-sous-titre text-on-surface">Patients récents</h3>
                    </div>
                </div>
                <div class="space-y-4">
                    @forelse ($patientsRecents as $patient)
                    <div class="flex items-center p-3 rounded-lg hover:bg-fond-page transition-colors cursor-pointer border border-transparent hover:border-bordure-douce">
                        <div class="w-10 h-10 bg-secondary-fixed-dim rounded-full flex items-center justify-center text-on-secondary-fixed font-label-fort mr-4">{{ strtoupper(substr($patient->prenom ?: 'P', 0, 1).substr($patient->nom ?: 'A', 0, 1)) }}</div>
                        <div>
                            <p class="font-label-fort text-label-fort text-on-surface">{{ $patient->prenom }} {{ $patient->nom }}</p>
                            <p class="font-corps-dense text-corps-dense text-on-surface-variant">Dossier patient {{ $patient->id_patient }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="p-3 text-corps-dense text-on-surface-variant">Aucun patient récent.</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.dashboard', ['section' => 'patients']) }}" class="block w-full mt-6 py-2 text-center text-primary font-label-fort text-label-fort border border-bordure-douce rounded-lg hover:bg-surface-container-low transition-colors">
                    Recherche Patient
                </a>
            </div>
        </div>
        @endif

        @if ($section)
            <section class="mt-8 {{ in_array($section, ['rendez-vous', 'services', 'medecins'], true) ? '' : 'rounded-xl border border-outline-variant/60 bg-surface-container-lowest p-6 shadow-[0px_8px_24px_rgba(15,42,67,0.08)]' }}" aria-label="Fenêtre {{ ucfirst($section) }}">
                @if ($section !== 'rendez-vous')
                    <div class="mb-6 flex items-start justify-between gap-4 border-b border-outline-variant/40 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-3xl">{{ $section === 'medecins' ? 'stethoscope' : ($section === 'patients' ? 'group' : 'business') }}</span>
                            <div>
                                <h2 class="font-sous-titre text-sous-titre text-on-surface">{{ ucfirst($section) }}</h2>
                                <p class="font-corps-dense text-corps-dense text-on-surface-variant">Cette vue reste intégrée au tableau de bord.</p>
                            </div>
                        </div>
                        <a class="flex items-center gap-1 rounded-lg px-3 py-2 text-primary hover:bg-surface-container-low" href="{{ route('admin.dashboard') }}">
                            <span class="material-symbols-outlined">close</span> Fermer
                        </a>
                    </div>
                @endif
                @if ($section === 'medecins')
                    @include('admin.docteur.indexdocteur')
                @elseif ($section === 'patients')
                    @if ($patientEdit)
                        <form method="POST" action="{{ route('admin.patients.update', $patientEdit->id_patient) }}" class="mb-6 grid gap-3 rounded-xl border border-outline-variant/40 bg-surface-container-lowest p-5 sm:grid-cols-2">@csrf @method('PUT')<input name="prenom" required value="{{ $patientEdit->prenom }}" class="rounded-lg border border-outline-variant px-3 py-2" placeholder="Prénom"><input name="nom" required value="{{ $patientEdit->nom }}" class="rounded-lg border border-outline-variant px-3 py-2" placeholder="Nom"><select name="sexe" class="rounded-lg border border-outline-variant px-3 py-2"><option value="M" @selected($patientEdit->sexe === 'M')>Masculin</option><option value="F" @selected($patientEdit->sexe === 'F')>Féminin</option><option value="X" @selected($patientEdit->sexe === 'X')>Autre</option></select><input name="telephone" value="{{ $patientEdit->telephone }}" class="rounded-lg border border-outline-variant px-3 py-2" placeholder="Téléphone"><input name="email" type="email" value="{{ $patientEdit->email }}" class="rounded-lg border border-outline-variant px-3 py-2" placeholder="Email"><div class="flex items-center gap-2"><button class="rounded-lg bg-primary px-4 py-2 font-semibold text-white">Enregistrer</button><a href="{{ route('admin.dashboard', ['section' => 'patients']) }}" class="rounded-lg border border-outline-variant px-4 py-2">Annuler</a></div></form>
                    @endif
                    <div class="overflow-x-auto"><table class="w-full text-left"><thead><tr class="border-b border-outline-variant/40 text-xs uppercase tracking-wide text-on-surface-variant"><th class="px-4 py-3">Patient</th><th class="px-4 py-3">Sexe</th><th class="px-4 py-3">Téléphone</th><th class="px-4 py-3 text-right">Action</th></tr></thead><tbody class="divide-y divide-outline-variant/30">@forelse ($patients as $patient)<tr class="hover:bg-fond-page"><td class="px-4 py-4 font-semibold">{{ $patient->prenom }} {{ $patient->nom }}</td><td class="px-4 py-4">{{ $patient->sexe ?: '—' }}</td><td class="px-4 py-4">{{ $patient->telephone ?: '—' }}</td><td class="px-4 py-4 text-right"><a href="{{ route('admin.dashboard', ['section' => 'patients', 'edit' => $patient->id_patient]) }}" class="mr-2 rounded-lg px-3 py-2 text-sm font-semibold text-primary hover:bg-surface-container-low">Modifier</a><form method="POST" action="{{ route('admin.patients.destroy', $patient->id_patient) }}" class="inline" onsubmit="return confirm('Êtes-vous vraiment sûr de vouloir supprimer ce patient ? Cette action est irréversible.')">@csrf @method('DELETE')<button class="rounded-lg px-3 py-2 text-sm font-semibold text-error hover:bg-error-container/30">Supprimer</button></form></td></tr>@empty<tr><td colspan="4" class="px-4 py-8 text-center text-on-surface-variant">Aucun patient enregistré.</td></tr>@endforelse</tbody></table></div>
                @elseif ($section === 'rendez-vous')
                    @include('admin.rendezvous.index')
                @elseif ($section === 'services')
                    @include('admin.services.index')
                @elseif ($section === 'parametres')
                    @include('admin.settings')
                @elseif ($section === 'carnets')
                    @include('admin.carnets.index')
                @elseif ($section === 'utilisateurs' && $user->isAdministrator())
                    @if ($userEdit)
                    <form method="POST" action="{{ route('admin.users.update', $userEdit->id_user) }}" class="mb-8 grid gap-4 rounded-xl border border-primary/30 bg-surface-container-lowest p-6 md:grid-cols-2">
                        @csrf @method('PUT')
                        <h3 class="text-xl font-bold text-on-surface md:col-span-2">Modifier l’utilisateur</h3>
                        <input name="prenom" required maxlength="100" value="{{ $userEdit->prenom }}" class="rounded-lg border border-outline-variant px-3 py-3" placeholder="Prénom">
                        <input name="nom" required maxlength="100" value="{{ $userEdit->nom }}" class="rounded-lg border border-outline-variant px-3 py-3" placeholder="Nom">
                        <input name="email" type="email" required maxlength="255" value="{{ $userEdit->email }}" class="rounded-lg border border-outline-variant px-3 py-3" placeholder="E-mail">
                        <input name="telephone" maxlength="30" value="{{ $userEdit->docteur_telephone ?? $userEdit->service_telephone ?? '' }}" class="rounded-lg border border-outline-variant px-3 py-3" placeholder="Téléphone">
                        <input name="specialite" required maxlength="150" value="{{ $userEdit->specialite ?? $userEdit->nom_service ?? '' }}" class="rounded-lg border border-outline-variant px-3 py-3" placeholder="Spécialité ou nom du service">
                        <div class="flex items-center gap-2"><button class="rounded-lg bg-primary px-5 py-3 font-semibold text-white" type="submit">Enregistrer</button><a href="{{ route('admin.dashboard', ['section' => 'utilisateurs']) }}" class="rounded-lg border border-outline-variant px-5 py-3">Annuler</a></div>
                    </form>
                    @endif
                    <div class="mb-8 rounded-xl border border-outline-variant/40 bg-surface-container-lowest p-6">
                        <h3 class="text-xl font-bold text-on-surface">Ajouter un utilisateur</h3>
                        <p class="mt-1 text-sm text-on-surface-variant">Seul l’administrateur de l’hôpital peut créer les comptes du personnel.</p>
                        @if (session('success') || session('warning'))
                            <div class="mt-4 rounded-lg border px-4 py-3 text-sm {{ session('warning') ? 'border-amber-200 bg-amber-50 text-amber-800' : 'border-emerald-200 bg-emerald-50 text-emerald-800' }}">{{ session('warning') ?? session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('admin.users.store') }}" class="mt-5 grid gap-4 md:grid-cols-2" data-user-creation-form>
                            @csrf
                            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Type d’utilisateur
                                <select name="role" required class="rounded-lg border border-outline-variant px-3 py-3" data-user-role>
                                    <option value="role-doctor">Docteur / médecin</option>
                                    <option value="role-service">Service</option>
                                </select>
                            </label>
                            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant"><span data-user-specialty-label>Spécialité du docteur</span>
                                <input name="specialite" required maxlength="150" class="rounded-lg border border-outline-variant px-3 py-3" placeholder="Ex. Ophtalmologie" data-user-specialty-input>
                            </label>
                            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Prénom
                                <input name="prenom" required maxlength="100" class="rounded-lg border border-outline-variant px-3 py-3">
                            </label>
                            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Nom
                                <input name="nom" required maxlength="100" class="rounded-lg border border-outline-variant px-3 py-3">
                            </label>
                            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">E-mail de connexion
                                <input name="email" type="email" required maxlength="255" class="rounded-lg border border-outline-variant px-3 py-3">
                            </label>
                            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Téléphone
                                <input name="telephone" maxlength="30" class="rounded-lg border border-outline-variant px-3 py-3">
                            </label>
                            <button class="rounded-lg bg-primary px-5 py-3 font-semibold text-white md:col-span-2 md:justify-self-end" type="submit">Créer le compte et envoyer les identifiants</button>
                        </form>
                    </div>
                    <div class="overflow-x-auto"><table class="w-full text-left"><thead><tr class="border-b border-outline-variant/40 text-xs uppercase tracking-wide text-on-surface-variant"><th class="px-4 py-3">Utilisateur</th><th class="px-4 py-3">Rôle</th><th class="px-4 py-3">Première connexion</th><th class="px-4 py-3">Compte</th><th class="px-4 py-3">Actions</th></tr></thead><tbody class="divide-y divide-outline-variant/30">@forelse($utilisateurs as $item)<tr><td class="px-4 py-4 font-semibold">{{ $item->prenom }} {{ $item->nom }}<div class="text-sm font-normal text-on-surface-variant">{{ $item->email }}</div></td><td class="px-4 py-4">{{ ucfirst($item->libelle_role ?? '—') }}</td><td class="px-4 py-4">{{ ($item->doit_changer_mot_de_passe ?? false) ? 'À modifier' : 'Terminée' }}</td><td class="px-4 py-4">{{ ($item->est_actif ?? true) ? 'Actif' : 'Désactivé' }}</td><td class="px-4 py-4"><div class="flex flex-wrap gap-2"><a href="{{ route('admin.dashboard', ['section' => 'utilisateurs', 'edit' => $item->id_user]) }}" class="rounded-lg border border-outline-variant px-3 py-2 text-sm font-semibold text-primary">Modifier</a>@if ($item->id_role !== 'role-admin')<form method="POST" action="{{ route('admin.users.toggle', $item->id_user) }}" onsubmit="return confirm('Voulez-vous vraiment modifier le statut de cet utilisateur ?')">@csrf @method('PATCH')<button class="rounded-lg border border-outline-variant px-3 py-2 text-sm font-semibold">{{ ($item->est_actif ?? true) ? 'Désactiver' : 'Activer' }}</button></form><form method="POST" action="{{ route('admin.users.destroy', $item->id_user) }}" onsubmit="return confirm('Êtes-vous vraiment sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700">Supprimer</button></form>@endif</div></td></tr>@empty<tr><td colspan="5" class="px-4 py-8 text-center">Aucun utilisateur.</td></tr>@endforelse</tbody></table></div>
                @else
                    <p class="py-6 font-corps-dense text-corps-dense text-on-surface-variant">La gestion de cette rubrique sera disponible dans cette fenêtre.</p>
                @endif
            </section>
        @endif
    </div>

    <!-- Footer -->
    <footer class="mt-8 flex w-full flex-col items-start gap-3 border-t border-bordure-douce bg-surface-container-highest px-4 py-gouttiere sm:mt-espacement-section sm:flex-row sm:items-center sm:justify-between sm:px-marge-page dark:bg-inverse-surface">
        <p class="font-mention-legale text-mention-legale text-on-surface-variant dark:text-outline-variant">© {{ date('Y') }} HealthPass - Protection des Données de Santé</p>
        <div class="flex flex-wrap gap-x-6 gap-y-2">
            <a class="font-mention-legale text-mention-legale text-on-surface-variant hover:text-primary transition-colors" href="#">Confidentialité</a>
            <a class="font-mention-legale text-mention-legale text-on-surface-variant hover:text-primary transition-colors" href="#">Mentions Légales</a>
        </div>
    </footer>
</main>
</body>
</html>
