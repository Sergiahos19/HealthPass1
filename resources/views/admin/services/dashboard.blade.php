<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tableau de Bord Service - HealthPass</title>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind Config Injection -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#cce5ff",
                        "acces-temporaire": "#D97706",
                        "surface-container-high": "#dde9ff",
                        "outline-variant": "#bec8cd",
                        "on-tertiary-fixed-variant": "#693c00",
                        "on-primary-fixed-variant": "#004d62",
                        "surface": "#f8f9ff",
                        "on-primary-fixed": "#001f29",
                        "surface-container-low": "#eff4ff",
                        "tertiary-container": "#965e1c",
                        "tertiary": "#794602",
                        "error-container": "#ffdad6",
                        "primary-fixed": "#b9eaff",
                        "inverse-on-surface": "#ebf1ff",
                        "background": "#f8f9ff",
                        "on-surface": "#0d1c2f",
                        "on-background": "#0d1c2f",
                        "on-error-container": "#93000a",
                        "on-tertiary": "#ffffff",
                        "surface-tint": "#006781",
                        "secondary-fixed-dim": "#93ccff",
                        "inverse-surface": "#233144",
                        "on-secondary-container": "#00476e",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#005a71",
                        "on-primary": "#ffffff",
                        "fond-page": "#F8FAFC",
                        "on-tertiary-fixed": "#2c1600",
                        "primary-fixed-dim": "#81d1f0",
                        "primary-container": "#0e7490",
                        "surface-container": "#e6eeff",
                        "on-secondary-fixed": "#001d31",
                        "surface-dim": "#ccdbf4",
                        "error": "#ba1a1a",
                        "surface-variant": "#d5e3fd",
                        "on-error": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "on-tertiary-container": "#ffe8d6",
                        "succes-biometrie": "#059669",
                        "tertiary-fixed": "#ffdcbd",
                        "alerte-critique": "#DC2626",
                        "bordure-douce": "#F1F5F9",
                        "inverse-primary": "#81d1f0",
                        "surface-container-highest": "#d5e3fd",
                        "on-primary-container": "#d3f1ff",
                        "tertiary-fixed-dim": "#ffb86f",
                        "secondary-container": "#5bb8fe",
                        "on-secondary-fixed-variant": "#004b73",
                        "on-surface-variant": "#3f484c",
                        "outline": "#6f787d",
                        "secondary": "#006398"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "espacement-section": "40px",
                        "marge-page": "24px",
                        "gouttiere": "16px",
                        "padding-carte": "20px",
                        "unite-base": "4px"
                    },
                    fontFamily: {
                        "label-fort": ["Inter"],
                        "titre-ecran-mobile": ["Plus Jakarta Sans"],
                        "titre-section": ["Plus Jakarta Sans"],
                        "corps-standard": ["Inter"],
                        "sous-titre": ["Plus Jakarta Sans"],
                        "mention-legale": ["Inter"],
                        "titre-ecran": ["Plus Jakarta Sans"],
                        "corps-dense": ["Inter"]
                    },
                    fontSize: {
                        "label-fort": ["14px", { lineHeight: "16px", fontWeight: "600" }],
                        "titre-ecran-mobile": ["24px", { lineHeight: "30px", fontWeight: "700" }],
                        "titre-section": ["22px", { lineHeight: "28px", fontWeight: "600" }],
                        "corps-standard": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "sous-titre": ["18px", { lineHeight: "24px", fontWeight: "600" }],
                        "mention-legale": ["12px", { lineHeight: "16px", fontWeight: "400" }],
                        "titre-ecran": ["30px", { lineHeight: "38px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "corps-dense": ["14px", { lineHeight: "20px", fontWeight: "400" }]
                    },
                    boxShadow: {
                        'carte-medicale': '0px 4px 12px rgba(51, 65, 85, 0.05)'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-fond-page text-on-surface font-corps-standard h-screen flex overflow-hidden">

    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 flex justify-between items-center px-marge-page h-16 bg-surface border-b border-bordure-douce shadow-sm">
        <div class="flex items-center gap-4">
            <div class="font-titre-ecran text-titre-ecran font-bold text-primary">HealthPass</div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex bg-surface-container-low rounded-full px-4 py-2 items-center">
                <span class="material-symbols-outlined text-on-surface-variant mr-2" style="font-variation-settings: 'FILL' 0;">search</span>
                <input class="bg-transparent border-none outline-none text-corps-standard font-corps-standard text-on-surface placeholder-on-surface-variant w-48" placeholder="Recherche..." type="text"/>
            </div>
            <button aria-label="notifications" class="p-2 text-on-surface-variant hover:bg-surface-container-low transition-colors rounded-full">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">notifications</span>
            </button>
            <button aria-label="security" class="p-2 text-on-surface-variant hover:bg-surface-container-low transition-colors rounded-full">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">security</span>
            </button>
            <div class="hidden md:flex items-center gap-2 rounded-lg bg-surface-container-low px-3 py-2 text-on-surface-variant"><span class="material-symbols-outlined">business</span><span class="font-label-fort text-label-fort">{{ $service->nom_service }}</span></div>
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
                <a class="flex items-center gap-3 px-3 py-2 bg-secondary-container text-on-secondary-container rounded-lg font-label-fort text-label-fort transition-colors" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                        Tableau de bord
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-fort text-label-fort" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">folder_shared</span>
                    Carnets Médicaux
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-fort text-label-fort" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">science</span>
                    Analyses
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-fort text-label-fort" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">domain</span>
                    Établissements
                </a>
            </li>
            <li>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-fort text-label-fort" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">settings</span>
                    Paramètres
                </a>
            </li>
        </ul>

        <div class="mt-auto mb-4">
            <button class="w-full flex items-center justify-between px-3 bg-error-container text-on-error-container font-label-fort text-label-fort py-2 rounded-lg border border-alerte-critique/20 hover:bg-error/10 transition-colors">
                <span>Urgence: 15</span>
                <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">call</span>
            </button>
        </div>

        <div class="border-t border-bordure-douce pt-2">
            <div class="font-mention-legale text-[11px] text-on-surface-variant">
                © 2024 HealthPass - Sécurité des données de santé certifiée
            </div>
        </div>
    </nav>

    <!-- Main Content Canvas -->
    <main class="flex-1 mt-16 md:ml-64 p-marge-page overflow-y-auto bg-fond-page pb-12">
        
        <!-- Header Section -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-titre-ecran text-titre-ecran md:text-[28px] text-titre-ecran-mobile text-on-surface">Tableau de Bord Service</h1>
            <p class="font-corps-standard text-corps-standard text-on-surface-variant mt-0.5">{{ $service->type_service ?: 'Service médical' }} · {{ $service->nom_service }}</p>
            </div>
            <button class="border border-bordure-douce bg-surface-container-lowest text-on-surface-variant font-label-fort text-label-fort px-3 py-1.5 rounded-lg flex items-center justify-center gap-1 hover:bg-surface-container-low transition-colors shadow-sm self-start sm:self-auto">
                <span class="material-symbols-outlined text-titre-section">filter_list</span>
                Filtrer
            </button>
        </div>

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
            <div class="lg:col-span-2 bg-surface-container-lowest border border-bordure-douce rounded-xl p-padding-carte shadow-carte-medicale">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-sous-titre text-sous-titre text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">list_alt</span>
                        Demandes d'Analyses
                    </h2>
                    <a href="#" class="font-label-fort text-xs text-secondary hover:underline">Voir tout</a>
                </div>

                <div class="flex flex-col gap-3">
                    @forelse ($demandesRecentes as $demande)
                        <div class="flex items-center justify-between gap-3 rounded-lg border border-bordure-douce bg-fond-page p-3 transition-colors hover:bg-surface-container-low">
                            <div class="flex min-w-0 items-center gap-3"><div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-surface-variant font-label-fort text-xs font-bold text-primary">{{ strtoupper(substr($demande->prenom ?: 'P', 0, 1).substr($demande->nom ?: 'A', 0, 1)) }}</div><div class="min-w-0"><h4 class="truncate font-label-fort text-sm text-on-surface">{{ $demande->prenom }} {{ $demande->nom }}</h4><p class="font-mention-legale text-xs text-on-surface-variant"><span class="material-symbols-outlined align-middle text-[14px]">science</span> {{ $demande->libelle_format ?: 'Analyse' }}</p></div></div>
                            <div class="flex shrink-0 items-center gap-3"><div class="hidden text-right sm:block"><span class="block font-label-fort text-xs text-on-surface">Dr {{ $demande->docteur_prenom }} {{ $demande->docteur_nom }}</span><span class="font-mention-legale text-[11px] text-on-surface-variant">{{ $demande->date_resultat }}</span></div><span class="rounded px-2 py-0.5 font-label-fort text-[11px] {{ $demande->statut === 'Urgent' ? 'bg-error-container text-alerte-critique' : 'bg-surface-container-high text-on-secondary-container' }}">{{ $demande->statut ?: 'En attente' }}</span></div>
                        </div>
                    @empty
                        <p class="rounded-lg border border-dashed border-outline-variant p-8 text-center font-corps-dense text-corps-dense text-on-surface-variant">Aucune demande d’analyse enregistrée.</p>
                    @endforelse
                </div>
            </div>

            <!-- Right Column Widgets -->
            <div class="flex flex-col gap-6">
                <!-- État du Système -->
                <div class="bg-surface-container-lowest border border-bordure-douce rounded-xl p-padding-carte shadow-carte-medicale">
                    <h3 class="font-sous-titre text-base text-on-surface mb-4">État du Système</h3>
                    
                    <div class="space-y-3 font-corps-dense text-xs">
                        <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                            <span class="text-on-surface-variant">Demandes enregistrées</span>
                            <span class="font-semibold text-on-surface">{{ $demandes }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                            <span class="text-on-surface-variant">Demandes urgentes</span>
                            <span class="font-semibold text-alerte-critique">{{ $urgentes }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-3">
                            <span class="text-on-surface-variant">Demandes traitées</span>
                            <span class="font-semibold text-succes-biometrie">{{ $traitees }}</span>
                        </div>
                    </div>
                </div>

                <!-- Formats de Soumission -->
                <div class="bg-surface-container-lowest border border-bordure-douce rounded-xl p-padding-carte shadow-carte-medicale">
                    <h3 class="font-sous-titre text-base text-on-surface mb-4">Formats de Soumission</h3>
                    
                    <div class="space-y-1.5 font-corps-dense text-xs text-on-surface-variant">
                        @forelse ($formats as $format)
                            <div class="flex items-center justify-between"><span>{{ $format->type_examen ?: 'Format non renseigné' }}</span><span class="font-mono text-on-surface">{{ round($format->total * 100 / $formatsTotal) }}%</span></div>
                        @empty
                            <p>Aucun format de soumission enregistré.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer mobile/web fixe facultatif (représenté dans l'image tout en bas) -->
    <footer class="fixed bottom-0 left-0 md:left-64 right-0 bg-surface-container-low border-t border-bordure-douce py-1.5 px-marge-page text-[11px] font-mention-legale text-on-surface-variant flex justify-between items-center z-30">
        <div>© 2024 HealthPass - Sécurité des données de santé certifiée</div>
        <div class="hidden sm:flex gap-4">
            <a href="#" class="hover:underline">Mentions Légales</a>
            <a href="#" class="hover:underline">Politique de Confidentialité</a>
            <a href="#" class="hover:underline">Aide</a>
            <a href="#" class="hover:underline">Support Technique</a>
        </div>
    </footer>

</body>
</html>