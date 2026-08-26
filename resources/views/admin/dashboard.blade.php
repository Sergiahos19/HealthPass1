<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>HealthPass - Tableau de Bord Administration</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "acces-temporaire": "#D97706",
                        "on-error-container": "#93000a",
                        "on-surface-variant": "#3f484c",
                        "on-secondary-fixed": "#001d31",
                        "surface-container": "#e6eeff",
                        "on-tertiary-container": "#ffe8d6",
                        "bordure-douce": "#F1F5F9",
                        "primary-fixed": "#b9eaff",
                        "tertiary": "#794602",
                        "outline-variant": "#bec8cd",
                        "inverse-surface": "#233144",
                        "on-secondary-fixed-variant": "#004b73",
                        "on-primary-fixed": "#001f29",
                        "primary-container": "#0e7490",
                        "tertiary-fixed-dim": "#ffb86f",
                        "on-secondary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#93ccff",
                        "tertiary-container": "#965e1c",
                        "surface-container-highest": "#d5e3fd",
                        "surface-container-high": "#dde9ff",
                        "primary": "#005a71",
                        "on-background": "#0d1c2f",
                        "on-secondary-container": "#00476e",
                        "tertiary-fixed": "#ffdcbd",
                        "surface-dim": "#ccdbf4",
                        "on-tertiary-fixed": "#2c1600",
                        "error-container": "#ffdad6",
                        "outline": "#6f787d",
                        "inverse-primary": "#81d1f0",
                        "on-tertiary-fixed-variant": "#693c00",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed": "#cce5ff",
                        "on-surface": "#0d1c2f",
                        "surface-container-low": "#eff4ff",
                        "surface-variant": "#d5e3fd",
                        "error": "#ba1a1a",
                        "on-primary": "#ffffff",
                        "on-primary-fixed-variant": "#004d62",
                        "secondary": "#006398",
                        "background": "#f8f9ff",
                        "surface-tint": "#006781",
                        "succes-biometrie": "#059669",
                        "secondary-container": "#5bb8fe",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#ebf1ff",
                        "surface": "#f8f9ff",
                        "primary-fixed-dim": "#81d1f0",
                        "alerte-critique": "#DC2626",
                        "surface-bright": "#f8f9ff",
                        "fond-page": "#F8FAFC",
                        "on-primary-container": "#d3f1ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gouttiere": "16px",
                        "espacement-section": "40px",
                        "marge-page": "24px",
                        "unite-base": "4px",
                        "padding-carte": "20px"
                    },
                    "fontFamily": {
                        "corps-dense": ["Inter"],
                        "titre-ecran": ["Plus Jakarta Sans"],
                        "titre-ecran-mobile": ["Plus Jakarta Sans"],
                        "sous-titre": ["Plus Jakarta Sans"],
                        "titre-section": ["Plus Jakarta Sans"],
                        "mention-legale": ["Inter"],
                        "label-fort": ["Inter"],
                        "corps-standard": ["Inter"]
                    },
                    "fontSize": {
                        "corps-dense": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "titre-ecran": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "titre-ecran-mobile": ["24px", { "lineHeight": "30px", "fontWeight": "700" }],
                        "sous-titre": ["18px", { "lineHeight": "24px", "fontWeight": "600" }],
                        "titre-section": ["22px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "mention-legale": ["12px", { "lineHeight": "16px", "fontWeight": "400" }],
                        "label-fort": ["14px", { "lineHeight": "16px", "fontWeight": "600" }],
                        "corps-standard": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
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
<body class="bg-fond-page text-on-surface font-corps-standard min-h-screen flex">

<!-- SideNavBar -->
<aside class="fixed left-0 top-0 z-50 hidden h-full w-64 flex-col bg-surface-container-low py-espacement-section shadow-sm md:flex dark:bg-inverse-surface">
    <div class="px-marge-page mb-8">
        <h1 class="text-sous-titre font-sous-titre text-primary dark:text-primary-fixed-dim">HealthPass</h1>
    </div>
    <div class="px-marge-page mb-8 flex items-center space-x-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-surface-variant text-primary">
            <span class="material-symbols-outlined text-2xl">account_circle</span>
        </div>
        <div>
            <p class="font-label-fort text-label-fort text-primary dark:text-primary-fixed-dim">{{ $etablissement?->nom_etablissement ?? 'Établissement' }}</p>
        </div>
    </div>
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
        <header class="sticky top-0 z-40 flex min-h-16 w-full items-center justify-between border-b border-bordure-douce bg-surface px-4 shadow-sm dark:border-outline-variant dark:bg-inverse-surface sm:px-marge-page">
            <div class="flex min-w-0 items-center">
                <span class="material-symbols-outlined mr-3 text-primary">security</span>
                <h2 class="truncate font-titre-section text-titre-section text-primary">Portail Santé Sécurisé</h2>
            </div>
            <div class="ml-4 flex shrink-0 items-center space-x-1 sm:space-x-4">
                <button aria-label="Voir les notifications" class="rounded-full p-2 text-on-surface-variant transition-colors hover:bg-surface-container-low">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button aria-label="Ouvrir le profil" class="rounded-full p-2 text-on-surface-variant transition-colors hover:bg-surface-container-low">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>
            </div>
        </header>
    @endif

    <div class="mx-auto w-full max-w-[1600px] flex-1 p-4 sm:p-marge-page lg:px-10">
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
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                <h1 class="font-titre-ecran text-titre-ecran text-on-surface mb-2">Tableau de Bord Administration</h1>
                <p class="font-corps-standard text-corps-standard text-on-surface-variant">Vue d'ensemble et gestion des flux administratifs d'aujourd'hui.</p>
            </div>
            <div class="flex items-center gap-3 bg-surface-container-lowest border border-outline-variant/60 rounded-full px-4 py-2 shadow-sm">
                <span class="material-symbols-outlined text-outline">calendar_today</span>
                <span class="font-label-fort text-label-fort text-on-surface">{{ date('d F Y') }}</span>
            </div>
        </header>

        <!-- Section: Aperçu -->
        <section class="space-y-gouttiere mb-8">
            <h2 class="font-sous-titre text-sous-titre text-on-surface flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">monitoring</span>
                Aperçu
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gouttiere">
                <!-- Metric Card 1 -->
                <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/60 shadow-[0px_4px_12px_rgba(51,65,85,0.05)] hover:shadow-[0px_8px_20px_rgba(51,65,85,0.08)] transition-all group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary-container/30 rounded-full blur-xl group-hover:bg-primary-container/50 transition-colors"></div>
                    <div class="flex items-start justify-between mb-6 relative z-10">
                        <div class="w-12 h-12 rounded-full bg-surface-container text-primary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">event_available</span>
                        </div>
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
                            <h3 class="font-titre-ecran text-titre-ecran text-on-surface">{{ $medecinsCount }}</h3>
                            <span class="font-corps-dense text-corps-dense text-outline">enregistrés</span>
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
                <button class="flex flex-col items-start justify-between h-40 p-6 bg-surface-container-lowest border border-outline-variant/60 rounded-xl shadow-[0px_4px_12px_rgba(51,65,85,0.05)] hover:shadow-[0px_8px_20px_rgba(51,65,85,0.08)] hover:border-secondary hover:-translate-y-1 transition-all duration-300 group text-left">
                    <div class="bg-surface-container p-2 rounded-lg mb-4 group-hover:bg-secondary-container transition-colors">
                        <span class="material-symbols-outlined text-secondary group-hover:text-on-secondary-container transition-colors">edit_calendar</span>
                    </div>
                    <div>
                        <h3 class="font-label-fort text-label-fort text-on-surface">Programmer un RDV</h3>
                        <p class="font-mention-legale text-mention-legale text-on-surface-variant mt-1">Accès planning centralisé</p>
                    </div>
                </button>
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
                <button class="w-full mt-6 py-2 text-center text-primary font-label-fort text-label-fort border border-bordure-douce rounded-lg hover:bg-surface-container-low transition-colors">
                    Recherche Patient
                </button>
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
                    <div class="divide-y divide-outline-variant/30">
                        @forelse ($patientsRecents as $patient)
                            <div class="flex items-center gap-3 py-4"><span class="material-symbols-outlined text-secondary text-3xl">account_circle</span><p class="font-label-fort text-label-fort text-on-surface">{{ $patient->prenom }} {{ $patient->nom }}</p></div>
                        @empty
                            <p class="py-6 font-corps-dense text-corps-dense text-on-surface-variant">Aucun patient enregistré.</p>
                        @endforelse
                    </div>
                @elseif ($section === 'rendez-vous')
                    @include('admin.rendezvous.index')
                @elseif ($section === 'services')
                    @include('admin.services.index')
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