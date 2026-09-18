<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>HealthPass - Analyses</title>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
</head>
<body class="hp-workspace hp-workspace-service bg-fond-page text-on-surface font-corps-standard h-screen flex flex-col overflow-hidden">

    <!-- TopNavBar -->
    <header class="w-full flex justify-between items-center px-marge-page h-16 bg-surface border-b border-bordure-douce shadow-sm shrink-0">
        <div class="flex items-center gap-4 flex-1">
            <div class="relative w-96 hidden md:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input class="w-full pl-10 pr-4 py-2 bg-fond-page border border-bordure-douce rounded-full font-corps-dense text-corps-dense focus:outline-none focus:border-secondary transition-shadow" placeholder="Rechercher un patient, une analyse (NIP...)" type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button aria-label="notifications" class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition-colors relative">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">notifications</span>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-alerte-critique rounded-full"></span>
            </button>
            <button aria-label="compte" class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
            </button>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="flex-1 p-marge-page overflow-y-auto bg-fond-page">
        <div class="max-w-350 mx-auto space-y-espacement-section">
            
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="font-titre-ecran text-titre-ecran text-on-surface">Gestion des Analyses</h1>
                    <p class="font-corps-standard text-corps-dense text-on-surface-variant flex items-center gap-2 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-acces-temporaire"></span>
                        0 analyse en attente de validation
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="border border-secondary text-secondary font-label-fort text-label-fort px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-surface-container transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-titre-section">filter_list</span>
                        Filtrer
                    </button>
                    <button class="bg-primary text-on-primary font-label-fort text-label-fort px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
                        <span class="material-symbols-outlined text-titre-section">add</span>
                        Nouvelle Analyse
                    </button>
                </div>
            </div>

            <!-- KPI Grid (4 Cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gouttiere">
                <!-- KPI 1 -->
                <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-start justify-between relative overflow-hidden">
                    <div>
                        <span class="font-corps-dense text-xs text-on-surface-variant">Total aujourd'hui</span>
                        <div class="font-titre-ecran text-3xl text-on-surface my-1">0</div>
                        <span class="font-label-fort text-xs text-on-surface-variant flex items-center gap-1 mt-2">
                            <span class="material-symbols-outlined text-sm">horizontal_rule</span> Aucune donnée disponible
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">science</span>
                    </div>
                </div>

                <!-- KPI 2 -->
                <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-start justify-between relative overflow-hidden">
                    <div>
                        <span class="font-corps-dense text-xs text-on-surface-variant">En attente (Résultats)</span>
                        <div class="font-titre-ecran text-3xl text-on-surface my-1">0</div>
                        <span class="font-label-fort text-xs text-on-surface-variant flex items-center gap-1 mt-2">
                            <span class="material-symbols-outlined text-sm">horizontal_rule</span> 0 urgente
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center text-acces-temporaire">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pending_actions</span>
                    </div>
                </div>

                <!-- KPI 3 -->
                <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-start justify-between relative overflow-hidden">
                    <div>
                        <span class="font-corps-dense text-xs text-on-surface-variant">Temps moyen (TAT)</span>
                        <div class="font-titre-ecran text-3xl text-on-surface my-1">0 h</div>
                        <span class="font-label-fort text-xs text-succes-biometrie flex items-center gap-1 mt-2">
                            <span class="material-symbols-outlined text-sm">check_circle</span> Objectif : &lt; 3h
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">timer</span>
                    </div>
                </div>

                <!-- KPI 4 -->
                <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale flex items-start justify-between relative overflow-hidden">
                    <div>
                        <span class="font-corps-dense text-xs text-on-surface-variant">Demandes STAT</span>
                        <div class="font-titre-ecran text-3xl text-alerte-critique my-1">0</div>
                        <span class="font-label-fort text-xs text-on-surface-variant flex items-center gap-1 mt-2">
                            <span class="material-symbols-outlined text-sm">priority_high</span> Nécessite attention
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-error-container flex items-center justify-center text-alerte-critique">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">emergency</span>
                    </div>
                </div>
            </div>

            <!-- Bento Main Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-gouttiere">
                
                <!-- Table Card (2 Cols) -->
                <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl border border-bordure-douce shadow-carte-medicale overflow-hidden flex flex-col">
                    <div class="p-4 border-b border-bordure-douce flex justify-between items-center bg-fond-page/50">
                        <h2 class="font-titre-section text-titre-section text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">list_alt</span>
                            Analyses Actives
                        </h2>
                        <a href="#" class="font-label-fort text-xs text-secondary hover:underline">Voir tout</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-fond-page border-b border-bordure-douce font-label-fort text-xs text-on-surface-variant">
                                    <th class="p-4 font-semibold">Patient / NIP</th>
                                    <th class="p-4 font-semibold">Type d'analyse</th>
                                    <th class="p-4 font-semibold">Statut</th>
                                    <th class="p-4 font-semibold">Priorité</th>
                                    <th class="p-4 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="font-corps-dense text-xs text-on-surface">
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-on-surface-variant">Aucune analyse enregistrée. Total : 0.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Side Panel Widgets -->
                <div class="flex flex-col gap-gouttiere">
                    
                    <!-- Progress Distribution Widget -->
                    <div class="bg-surface-container-lowest p-padding-carte rounded-xl border border-bordure-douce shadow-carte-medicale">
                        <h3 class="font-sous-titre text-sous-titre text-on-surface mb-4">Répartition par pôle</h3>
                        <div class="space-y-3 font-corps-dense text-xs">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-on-surface-variant">Biochimie</span>
                                    <span class="font-semibold text-on-surface">0%</span>
                                </div>
                                <div class="w-full bg-fond-page rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-on-surface-variant">Hématologie</span>
                                    <span class="font-semibold text-on-surface">0%</span>
                                </div>
                                <div class="w-full bg-fond-page rounded-full h-2">
                                    <div class="bg-secondary h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-on-surface-variant">Microbiologie</span>
                                    <span class="font-semibold text-on-surface">0%</span>
                                </div>
                                <div class="w-full bg-fond-page rounded-full h-2">
                                    <div class="bg-tertiary-container h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-on-surface-variant">Immunologie</span>
                                    <span class="font-semibold text-on-surface">0%</span>
                                </div>
                                <div class="w-full bg-fond-page rounded-full h-2">
                                    <div class="bg-outline h-2 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Box Widget -->
                    <div class="bg-surface-container-low rounded-xl p-padding-carte border border-primary/20 relative overflow-hidden">
                        <div class="flex items-center gap-2 mb-2 text-primary">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">info</span>
                            <h4 class="font-sous-titre text-sous-titre text-sm">Maintenance Prévue</h4>
                        </div>
                        <p class="font-corps-dense text-xs text-on-surface-variant leading-relaxed">
                            L'automate de biochimie (Cobas 8000) sera en maintenance préventive ce soir entre 22h00 et 00h00. Veuillez anticiper les urgences.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </main>

</body>
</html>
