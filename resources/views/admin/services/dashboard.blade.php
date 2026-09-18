<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Espace service - HealthPass</title>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
</head>
<body class="hp-workspace hp-workspace-service bg-fond-page text-on-surface font-corps-standard h-screen flex overflow-hidden">

    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 flex justify-between items-center px-marge-page h-16 bg-surface border-b border-bordure-douce shadow-sm">
        <div class="flex items-center gap-4">
            <div class="font-titre-ecran text-titre-ecran font-bold text-primary">HealthPass</div>
        </div>
        <div class="flex items-center gap-4">
        </div>
    </header>

    <!-- SideNavBar -->
    <nav class="hidden md:flex fixed left-0 top-16 h-[calc(100vh-64px)] w-64 bg-surface-container-lowest border-r border-bordure-douce flex-col p-4 z-40">
        <div class="mb-8 flex items-center gap-3 px-2">
            <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">local_hospital</span>
            </div>
            <div>
                <div class="font-titre-section text-titre-section text-primary text-sm leading-tight">{{ $service->nom_service }}</div>
                <div class="font-mention-legale text-mention-legale text-succes-biometrie flex items-center gap-1">
                    <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    Accès Sécurisé
                </div>
            </div>
        </div>
        
        <ul class="flex flex-col gap-2 grow">
            <li>
                <a @class(['flex items-center gap-3 px-3 py-2 rounded-lg font-label-fort text-label-fort transition-colors', 'bg-primary-container text-on-primary-container' => ! $section, 'text-on-surface-variant hover:bg-surface-container-high' => $section]) href="{{ route('service.dashboard') }}" @if (! $section) aria-current="page" @endif>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                        Tableau de bord
                </a>
            </li>
            <li>
                <a @class(['flex items-center gap-3 px-3 py-2 rounded-lg font-label-fort text-label-fort transition-colors', 'bg-primary-container text-on-primary-container' => $section === 'analyses', 'text-on-surface-variant hover:bg-surface-container-high' => $section !== 'analyses']) href="{{ route('service.analyses') }}" @if ($section === 'analyses') aria-current="page" @endif>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">science</span>
                    Analyses
                </a>
            </li>
            <li>
                <a @class(['flex items-center gap-3 px-3 py-2 rounded-lg font-label-fort text-label-fort transition-colors', 'bg-primary-container text-on-primary-container' => $section === 'parametres', 'text-on-surface-variant hover:bg-surface-container-high' => $section !== 'parametres']) href="{{ route('service.settings') }}" @if ($section === 'parametres') aria-current="page" @endif>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">settings</span>
                    Paramètres
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST" class="border-t border-bordure-douce pt-3">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 font-label-fort text-label-fort text-on-surface-variant transition-colors hover:bg-error-container hover:text-on-error-container">
                <span class="material-symbols-outlined">logout</span>
                Déconnexion
            </button>
        </form>

    </nav>

    <!-- Main Content Canvas -->
    <main class="flex-1 mt-16 md:ml-64 p-marge-page overflow-y-auto bg-fond-page pb-12">
        
        <!-- Header Section -->
        <div class="mb-8 flex flex-col gap-3 border-b border-outline-variant/40 pb-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-1 font-label-fort text-label-fort uppercase tracking-[0.14em] text-secondary">{{ $service->nom_service }}</p>
                <h1 class="font-titre-ecran text-titre-ecran md:text-[28px] text-titre-ecran-mobile text-on-surface">{{ $section === 'analyses' ? 'Analyses et résultats' : ($section === 'parametres' ? 'Paramètres du service' : 'Tableau de bord') }}</h1>
                <p class="mt-1 font-corps-standard text-corps-standard text-on-surface-variant">{{ $service->type_service ?: 'Service médical' }}</p>
            </div>
        </div>

        @if ($section === 'analyses')
            @include('admin.services.analyses-content')
        @elseif ($section === 'parametres')
            @include('admin.services.settings-content')
        @else
        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <!-- Card 1 -->
            <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-center justify-between">
                <div>
                    <span class="font-corps-dense text-xs text-on-surface-variant">En attente</span>
                    <div class="font-titre-ecran text-3xl text-on-surface my-1">{{ $demandes }}</div>
                    <span class="font-mention-legale text-xs text-on-surface-variant">Demandes reçues</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-primary-fixed/30 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">assignment</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-center justify-between">
                <div>
                    <span class="font-corps-dense text-xs text-on-surface-variant">Urgent</span>
                    <div class="font-titre-ecran text-3xl text-on-surface my-1">{{ $urgentes }}</div>
                    <span class="font-mention-legale text-xs text-on-surface-variant">Nécessite action immédiate</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-error-container flex items-center justify-center text-alerte-critique">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">warning</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-center justify-between">
                <div>
                    <span class="font-corps-dense text-xs text-on-surface-variant">Traitées ce jour</span>
                    <div class="font-titre-ecran text-3xl text-on-surface my-1">{{ $traitees }}</div>
                    <span class="font-mention-legale text-xs text-succes-biometrie">Traitements enregistrés</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-succes-biometrie">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
            </div>
        </div>

        <!-- Middle Section (Requests + System Status) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            
            <!-- Demandes d'Analyses (Takes 2 Columns) -->
            <div class="lg:col-span-3 bg-surface-container-lowest border border-bordure-douce rounded-xl p-padding-carte shadow-carte-medicale">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-sous-titre text-sous-titre text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">list_alt</span>
                        Demandes d'Analyses
                    </h2>
                    <a href="{{ route('service.analyses') }}" class="font-label-fort text-xs text-secondary hover:underline">Voir tout</a>
                </div>

                <div class="flex flex-col gap-3">
                    @forelse ($demandesRecentes as $demande)
                            <div class="flex items-center justify-between gap-3 rounded-lg border border-bordure-douce bg-fond-page p-3 transition-colors hover:bg-surface-container-low">
                            <div class="flex min-w-0 items-center gap-3"><div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-surface-variant font-label-fort text-xs font-bold text-primary">{{ strtoupper(substr($demande->prenom ?: 'P', 0, 1).substr($demande->nom ?: 'A', 0, 1)) }}</div><div class="min-w-0"><h4 class="truncate font-label-fort text-sm text-on-surface">{{ $demande->prenom }} {{ $demande->nom }}</h4><p class="font-mention-legale text-xs text-on-surface-variant"><span class="material-symbols-outlined align-middle text-[14px]">science</span> {{ $demande->libelle_format ?: 'Analyse' }}</p></div></div>
                            <div class="flex shrink-0 items-center gap-3"><span class="rounded px-2 py-0.5 font-label-fort text-[11px] {{ in_array($demande->priorite, ['Urgente', 'STAT'], true) ? 'bg-error-container text-alerte-critique' : 'bg-surface-container-high text-on-secondary-container' }}">{{ $demande->priorite }}</span><a href="{{ route('service.dashboard', ['section' => 'analyses', 'demande' => $demande->id_demande]) }}" aria-label="Voir la demande de {{ $demande->prenom }} {{ $demande->nom }}" title="Voir la demande" class="rounded-lg p-2 text-primary transition-colors hover:bg-primary/10"><span class="material-symbols-outlined">visibility</span></a></div>
                        </div>
                    @empty
                        <p class="rounded-lg border border-dashed border-outline-variant p-8 text-center font-corps-dense text-corps-dense text-on-surface-variant">Aucune demande d’analyse enregistrée.</p>
                    @endforelse
                </div>
            </div>

            @if ($demandeSelectionnee)
                <section class="mt-6 rounded-xl border border-primary/20 bg-surface-container-lowest p-5 shadow-carte-medicale" aria-label="Détail de la demande d’analyse">
                    <div class="mb-4 flex items-start justify-between gap-4 border-b border-bordure-douce pb-4">
                        <div><p class="text-xs font-semibold uppercase tracking-wider text-secondary">Détail de la demande</p><h3 class="mt-1 font-sous-titre text-sous-titre text-on-surface">{{ $demandeSelectionnee->prenom }} {{ $demandeSelectionnee->nom }}</h3></div>
                        <a href="{{ route('service.dashboard') }}" aria-label="Fermer le détail" title="Fermer" class="rounded-lg p-2 text-on-surface-variant hover:bg-surface-container"><span class="material-symbols-outlined">close</span></a>
                    </div>
                    <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3"><div><p class="text-on-surface-variant">Examen demandé</p><p class="mt-1 font-semibold text-on-surface">{{ $demandeSelectionnee->libelle_format }}{{ $demandeSelectionnee->type_examen ? ' · '.$demandeSelectionnee->type_examen : '' }}</p></div><div><p class="text-on-surface-variant">Priorité</p><p class="mt-1 font-semibold text-on-surface">{{ $demandeSelectionnee->priorite }}</p></div><div><p class="text-on-surface-variant">Demandé par</p><p class="mt-1 font-semibold text-on-surface">Dr {{ $demandeSelectionnee->docteur_prenom }} {{ $demandeSelectionnee->docteur_nom }}</p></div></div>
                </section>
            @endif

        </div>
        @endif

    </main>

    <!-- Footer mobile/web fixe facultatif (représenté dans l'image tout en bas) -->
    <footer class="fixed bottom-0 left-0 md:left-64 right-0 bg-surface-container-low border-t border-bordure-douce py-1.5 px-marge-page text-[11px] font-mention-legale text-on-surface-variant flex justify-between items-center z-30">
        <div>© {{ date('Y') }} HealthPass - Sécurité des données de santé certifiée</div>
        <div class="hidden sm:flex gap-4">
            <a href="#" class="hover:underline">Mentions Légales</a>
            <a href="#" class="hover:underline">Politique de Confidentialité</a>
            <a href="#" class="hover:underline">Aide</a>
            <a href="#" class="hover:underline">Support Technique</a>
        </div>
    </footer>

</body>
</html>
