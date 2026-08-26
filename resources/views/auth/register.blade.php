<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Inscription Établissement - HealthPass</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#b9eaff",
                        "tertiary-fixed": "#85f8c4",
                        "surface-container-highest": "#d5e3fd",
                        "inverse-primary": "#81d1f0",
                        "secondary-fixed-dim": "#93ccff",
                        "surface-dim": "#ccdbf4",
                        "on-tertiary-container": "#a3ffd2",
                        "outline": "#6f787d",
                        "surface-bright": "#f8f9ff",
                        "on-secondary-fixed-variant": "#004b73",
                        "on-secondary-container": "#00476e",
                        "surface": "#f8f9ff",
                        "on-surface": "#0d1c2f",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed": "#cce5ff",
                        "tertiary": "#005f41",
                        "on-background": "#0d1c2f",
                        "on-surface-variant": "#3f484c",
                        "surface-container-high": "#dde9ff",
                        "outline-variant": "#bec8cd",
                        "on-secondary-fixed": "#001d31",
                        "inverse-surface": "#233144",
                        "on-error-container": "#93000a",
                        "on-primary-fixed-variant": "#004d62",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#eff4ff",
                        "primary-container": "#0e7490",
                        "on-tertiary-fixed": "#002114",
                        "surface-variant": "#d5e3fd",
                        "error": "#ba1a1a",
                        "surface-tint": "#006781",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#ebf1ff",
                        "background": "#f8f9ff",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff",
                        "secondary": "#006398",
                        "surface-container": "#e6eeff",
                        "primary-fixed-dim": "#81d1f0",
                        "tertiary-fixed-dim": "#68dba9",
                        "on-primary-fixed": "#001f29",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#5bb8fe",
                        "on-tertiary-fixed-variant": "#005137",
                        "primary": "#005a71",
                        "on-primary-container": "#d3f1ff",
                        "tertiary-container": "#007a54"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "inter-element": "12px",
                        "inter-bloc": "32px",
                        "gouttiere": "16px",
                        "unite-base": "4px",
                        "marge-page": "24px"
                    },
                    "fontFamily": {
                        "corps-lg": ["Inter"],
                        "corps-sm": ["Inter"],
                        "titre-lg": ["Plus Jakarta Sans"],
                        "corps-md": ["Inter"],
                        "titre-xl": ["Plus Jakarta Sans"],
                        "titre-md": ["Plus Jakarta Sans"],
                        "mention": ["Inter"],
                        "titre-sm": ["Plus Jakarta Sans"],
                        "label-bold": ["Inter"]
                    },
                    "fontSize": {
                        "corps-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "corps-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "titre-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "corps-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "titre-xl": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "titre-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "mention": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "titre-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "label-bold": ["14px", { "lineHeight": "20px", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface-container-low text-on-background min-h-screen flex antialiased">

<div class="grid w-full min-h-screen gap-6 p-4 sm:p-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(460px,1.05fr)] lg:gap-8 lg:p-8 xl:p-10">
    <!-- Colonne Gauche: Choix de l'acteur -->
    <aside class="relative hidden min-h-screen overflow-hidden rounded-3xl bg-primary-container shadow-xl lg:flex">
        <div class="absolute inset-0 bg-linear-to-br from-on-primary-fixed/95 via-primary/90 to-primary-container"></div>
        <div class="relative z-10 flex w-full flex-col p-8 xl:p-12">
            <div class="mb-16 flex items-center gap-inter-element">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/95 shadow-lg ring-1 ring-white/40">
                    <span class="material-symbols-outlined icon-filled text-primary text-titre-md">health_and_safety</span>
                </div>
                <span class="font-titre-lg text-titre-lg text-white">HealthPass</span>
            </div>
            <div class="max-w-xl">
                <p class="mb-4 font-label-bold text-label-bold uppercase tracking-[0.18em] text-on-tertiary-container">Accès professionnel</p>
                <h1 class="font-titre-xl text-titre-xl text-white mb-gouttiere">Qui représentez-vous ?</h1>
                <p class="max-w-lg font-corps-lg text-corps-lg text-white/85">Choisissez votre profil pour ouvrir le parcours d'inscription adapté à votre activité.</p>
            </div>
            <div class="mt-12 space-y-3" role="tablist" aria-label="Type de compte">
                <button type="button" class="actor-choice flex w-full items-center gap-4 rounded-2xl border border-white/30 bg-white/15 p-4 text-left text-white shadow-lg backdrop-blur-sm transition-all" data-actor="etablissement" role="tab" aria-selected="true">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-primary"><span class="material-symbols-outlined icon-filled">domain</span></span>
                    <span class="min-w-0 flex-1"><strong class="block font-label-bold text-label-bold">Établissement</strong><small class="mt-1 block font-corps-sm text-corps-sm text-white/75">Hôpital, clinique ou cabinet</small></span>
                    <span class="material-symbols-outlined actor-check">check_circle</span>
                </button>
                <button type="button" class="actor-choice flex w-full items-center gap-4 rounded-2xl border border-white/15 bg-white/5 p-4 text-left text-white/85 transition-all hover:border-white/40 hover:bg-white/10" data-actor="medecin" role="tab" aria-selected="false">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10 text-on-tertiary-container"><span class="material-symbols-outlined">stethoscope</span></span>
                    <span class="min-w-0 flex-1"><strong class="block font-label-bold text-label-bold">Médecin</strong><small class="mt-1 block font-corps-sm text-corps-sm text-white/65">Professionnel de santé</small></span>
                    <span class="material-symbols-outlined actor-check hidden">check_circle</span>
                </button>
                <button type="button" class="actor-choice flex w-full items-center gap-4 rounded-2xl border border-white/15 bg-white/5 p-4 text-left text-white/85 transition-all hover:border-white/40 hover:bg-white/10" data-actor="service" role="tab" aria-selected="false">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/10 text-on-tertiary-container"><span class="material-symbols-outlined">medical_services</span></span>
                    <span class="min-w-0 flex-1"><strong class="block font-label-bold text-label-bold">Service</strong><small class="mt-1 block font-corps-sm text-corps-sm text-white/65">Laboratoire ou service médical</small></span>
                    <span class="material-symbols-outlined actor-check hidden">check_circle</span>
                </button>
            </div>
            <p class="mt-auto border-t border-white/20 pt-6 font-mention text-mention text-white/65">Un seul compte suffit pour commencer votre parcours HealthPass.</p>
        </div>
    </aside>

    <!-- Colonne Droite: Formulaire d'inscription -->
    <div class="relative flex w-full flex-col items-center rounded-3xl bg-surface-container-lowest px-5 py-8 shadow-xl sm:px-8 lg:px-12 lg:py-14">
        <div class="absolute left-5 top-5 flex items-center gap-inter-element sm:left-8 sm:top-8 lg:hidden">
            <div class="w-8 h-8 rounded bg-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined icon-filled text-on-primary-container text-corps-md">health_and_safety</span>
            </div>
            <span class="font-titre-sm text-titre-sm text-primary">HealthPass</span>
        </div>

        <div class="mt-16 w-full max-w-2xl lg:mt-0">
            <div class="mb-8 lg:hidden">
                <p class="mb-3 font-label-bold text-label-bold uppercase tracking-[0.16em] text-primary">Votre profil</p>
                <div class="grid grid-cols-3 gap-2" role="tablist" aria-label="Type de compte">
                    <button type="button" class="mobile-actor-choice rounded-xl border-2 border-primary bg-primary/5 p-3 text-center text-primary" data-actor="etablissement" aria-selected="true"><span class="material-symbols-outlined">domain</span><span class="mt-1 block text-xs font-semibold">Établissement</span></button>
                    <button type="button" class="mobile-actor-choice rounded-xl border border-outline-variant p-3 text-center text-on-surface-variant" data-actor="medecin" aria-selected="false"><span class="material-symbols-outlined">stethoscope</span><span class="mt-1 block text-xs font-semibold">Médecin</span></button>
                    <button type="button" class="mobile-actor-choice rounded-xl border border-outline-variant p-3 text-center text-on-surface-variant" data-actor="service" aria-selected="false"><span class="material-symbols-outlined">medical_services</span><span class="mt-1 block text-xs font-semibold">Service</span></button>
                </div>
            </div>
            @if (session('success'))
                <div class="mb-inter-bloc flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status">
                    <span class="material-symbols-outlined shrink-0">check_circle</span>
                    <p class="font-corps-sm text-corps-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-inter-bloc rounded-lg border border-red-200 bg-red-50 p-4 text-red-800" role="alert">
                    <p class="font-label-bold text-label-bold">Veuillez vérifier les informations saisies.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-10 border-b border-surface-variant pb-7">
                <p class="mb-3 font-label-bold text-label-bold uppercase tracking-[0.16em] text-primary" id="formEyebrow">Nouvel établissement</p>
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h2 class="font-titre-lg text-titre-lg text-on-surface mb-2" id="formTitle">Créer votre compte</h2>
                        <p class="font-corps-md text-corps-md text-on-surface-variant" id="formDescription">Renseignez les informations de votre établissement pour commencer.</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire Blade / Laravel -->
            <form id="establishmentForm" action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section: Informations Générales -->
                <section class="space-y-5 border-b border-surface-variant pb-8">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 text-primary">domain</span>
                        <div>
                            <h3 class="font-titre-sm text-titre-sm text-on-surface">Informations Générales</h3>
                            <p class="mt-1 font-corps-sm text-corps-sm text-on-surface-variant">Présentez votre établissement de santé.</p>
                        </div>
                    </div>
                    <div class="space-y-inter-element">
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="nomEtablissement">Nom de l'établissement <span class="text-error" aria-hidden="true">*</span></label>
                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="nomEtablissement" name="nom_etablissement" placeholder="Ex: CNHU" value="{{ old('nom_etablissement') }}" required type="text"/>
                        </div>
                        <div class="grid grid-cols-1 gap-gouttiere sm:grid-cols-2">
                            <div>
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="typeEtablissement">Type <span class="text-error" aria-hidden="true">*</span></label>
                                <div class="relative">
                                    <select class="w-full appearance-none rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="typeEtablissement" name="type_etablissement" required>
                                        <option disabled value="">Sélectionner...</option>
                                        <option value="hopital" @selected(old('type_etablissement') === 'hopital')>Hôpital</option>
                                        <option value="clinique" @selected(old('type_etablissement') === 'clinique')>Clinique</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-on-surface-variant">
                                        <span class="material-symbols-outlined">expand_more</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="ifuEtablissement">Numéro IFU <span class="text-error" aria-hidden="true">*</span></label>
                                <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="ifuEtablissement" name="ifu" placeholder="0000000000000" value="{{ old('ifu') }}" required type="text"/>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Localisation -->
                <section class="space-y-5 border-b border-surface-variant pb-8">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 text-primary">location_on</span>
                        <div>
                            <h3 class="font-titre-sm text-titre-sm text-on-surface">Localisation</h3>
                            <p class="mt-1 font-corps-sm text-corps-sm text-on-surface-variant">Indiquez où trouver votre établissement.</p>
                        </div>
                    </div>
                    <div class="space-y-inter-element">
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="adresse">Adresse </label>
                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="adresse" name="adresse" placeholder="Bénin, Cotonou" value="{{ old('adresse') }}" required type="text"/>
                        </div>
                        <div class="grid grid-cols-1 gap-gouttiere sm:grid-cols-3">
                            <div>
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="cp">Code Postal</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="cp" name="code_postal" placeholder="Ex: 00000" value="{{ old('code_postal') }}" required type="text"/>
                            </div>
                            <div class="col-span-2">
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="ville">Ville</label>
                                <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="ville" name="ville" placeholder="Ex: Cotonou" value="{{ old('ville') }}" required type="text"/>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Contact Administratif -->
                <section class="space-y-5 border-b border-surface-variant pb-8">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 text-primary">manage_accounts</span>
                        <div>
                            <h3 class="font-titre-sm text-titre-sm text-on-surface">Contact Administratif</h3>
                            <p class="mt-1 font-corps-sm text-corps-sm text-on-surface-variant">Ces informations serviront à gérer votre compte.</p>
                        </div>
                    </div>
                    <div class="space-y-inter-element">
                        <div class="grid grid-cols-1 gap-gouttiere sm:grid-cols-2">
                            <div>
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="prenomContact">Prénom <span class="text-error" aria-hidden="true">*</span></label>
                                <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="prenomContact" name="prenom_contact" value="{{ old('prenom_contact') }}" required type="text"/>
                            </div>
                            <div>
                                <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="nomContact">Nom <span class="text-error" aria-hidden="true">*</span></label>
                                <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="nomContact" name="nom_contact" value="{{ old('nom_contact') }}" required type="text"/>
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="emailContact">Email professionnel <span class="text-error" aria-hidden="true">*</span></label>
                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="emailContact" name="email_contact" placeholder="direction@clinique.fr" value="{{ old('email_contact') }}" required type="email"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-gouttiere sm:grid-cols-2">
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="password">Mot de passe <span class="text-error" aria-hidden="true">*</span></label>
                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="password" name="password" minlength="8" required type="password" autocomplete="new-password"/>
                        </div>
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="password_confirmation">Confirmation <span class="text-error" aria-hidden="true">*</span></label>
                            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 font-corps-md text-corps-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors" id="password_confirmation" name="password_confirmation" minlength="8" required type="password" autocomplete="new-password"/>
                        </div>
                    </div>
                </section>

                <section class="space-y-5 border-b border-surface-variant pb-8">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 text-primary">folder_open</span>
                        <div>
                            <h3 class="font-titre-sm text-titre-sm text-on-surface">Documents de l'établissement</h3>
                            <p class="mt-1 font-corps-sm text-corps-sm text-on-surface-variant">Ajoutez les justificatifs nécessaires à la certification.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="documentAutorisation">Autorisation ou certification <span class="text-error" aria-hidden="true">*</span></label>
                            <input class="block w-full cursor-pointer rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2.5 text-sm text-on-surface file:mr-4 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-2 file:font-semibold file:text-on-primary hover:file:bg-primary-container" id="documentAutorisation" name="document_autorisation" accept=".pdf,.jpg,.png" required type="file"/>
                            <p class="mt-1 font-mention text-mention text-outline">PDF, JPG ou PNG, 5 Mo maximum.</p>
                        </div>
                        <div>
                            <label class="block font-label-bold text-label-bold text-on-surface-variant mb-unite-base" for="photoEtablissement">Photo de l'établissement <span class="text-error" aria-hidden="true">*</span></label>
                            <input class="block w-full cursor-pointer rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2.5 text-sm text-on-surface file:mr-4 file:rounded-md file:border-0 file:bg-secondary file:px-3 file:py-2 file:font-semibold file:text-on-secondary hover:file:bg-secondary-container" id="photoEtablissement" name="photo_etablissement" accept="image/*" required type="file"/>
                            <p class="mt-1 font-mention text-mention text-outline">Une image claire de la façade ou de l'accueil.</p>
                        </div>
                    </div>
                </section>

                <!-- Actions -->
                <div class="space-y-4 pt-gouttiere">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-outline-variant bg-surface-container-low p-4 transition-colors has-checked:border-primary has-checked:bg-primary/5" for="confirmationInformations">
                        <input class="mt-1 h-4 w-4 shrink-0 accent-primary" id="confirmationInformations" name="confirmation_informations" @checked(old('confirmation_informations')) required type="checkbox"/>
                        <span class="font-corps-sm text-corps-sm text-on-surface-variant">Je confirme l'exactitude des informations fournies et autorise HealthPass à les vérifier. <span class="text-error" aria-hidden="true">*</span></span>
                    </label>
                    <button class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-surface-variant py-4 font-label-bold text-label-bold text-on-surface-variant shadow-sm transition-all duration-200 disabled:opacity-70 enabled:cursor-pointer enabled:bg-linear-to-r enabled:from-primary enabled:to-primary-container enabled:text-on-primary enabled:shadow-lg enabled:shadow-primary/25 enabled:ring-4 enabled:ring-primary/10 enabled:hover:-translate-y-0.5 enabled:hover:shadow-xl" id="submitButton" disabled type="submit">
                        <span>Continuer vers la validation</span>
                        <span class="material-symbols-outlined text-mention">arrow_forward</span>
                    </button>
                    <a class="flex w-full items-center justify-center gap-2 rounded-xl border border-outline-variant bg-surface-container-lowest py-3 font-label-bold text-label-bold text-on-surface-variant transition-colors hover:border-primary hover:bg-surface-container-low hover:text-primary" href="{{ route('home') }}">
                        <span class="material-symbols-outlined text-mention">arrow_back</span>
                        Retour à l'accueil
                    </a>
                    <div class="text-center">
                        <span class="font-corps-sm text-corps-sm text-on-surface-variant">Déjà inscrit ?</span>
                        <a class="font-label-bold text-label-bold text-primary hover:text-primary-container ml-1 transition-colors" href="#">Se connecter</a>
                    </div>
                </div>
            </form>

            <section id="doctorPanel" class="hidden" aria-live="polite">
                @include('auth.partials.doctor-form')
            </section>
            <section id="servicePanel" class="hidden" aria-live="polite">
                @include('auth.partials.service-form')
            </section>
            <section id="comingSoonPanel" class="hidden rounded-2xl border border-primary/20 bg-primary/5 p-6" aria-live="polite">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary text-on-primary"><span id="comingSoonIcon" class="material-symbols-outlined text-3xl">stethoscope</span></div>
                <h3 id="comingSoonTitle" class="mt-6 font-titre-md text-titre-md text-on-surface">Parcours médecin</h3>
                <p id="comingSoonDescription" class="mt-2 max-w-lg font-corps-md text-corps-md text-on-surface-variant">Ce formulaire sera bientôt disponible. Les informations et associations nécessaires seront ajoutées après votre validation.</p>
                <button type="button" class="mt-6 rounded-xl bg-primary px-5 py-3 font-label-bold text-label-bold text-on-primary transition-colors hover:bg-primary-container" data-reset-actor>Revenir à l'inscription établissement</button>
            </section>
        </div>
    </div>
</div>

<script>
    const confirmationCheckbox = document.getElementById('confirmationInformations');
    const submitButton = document.getElementById('submitButton');
    const establishmentForm = document.getElementById('establishmentForm');
    const doctorPanel = document.getElementById('doctorPanel');
    const servicePanel = document.getElementById('servicePanel');
    const comingSoonPanel = document.getElementById('comingSoonPanel');
    const formEyebrow = document.getElementById('formEyebrow');
    const formTitle = document.getElementById('formTitle');
    const formDescription = document.getElementById('formDescription');
    const comingSoonTitle = document.getElementById('comingSoonTitle');
    const comingSoonDescription = document.getElementById('comingSoonDescription');
    const comingSoonIcon = document.getElementById('comingSoonIcon');
    const actorChoices = document.querySelectorAll('[data-actor]');

    const actorContent = {
        medecin: { label: 'Parcours médecin', icon: 'stethoscope', description: 'Créez votre profil professionnel et rattachez-le à votre établissement.' },
        service: { label: 'Parcours service', icon: 'medical_services', description: 'Ce formulaire sera bientôt disponible. Les informations et associations nécessaires seront ajoutées après votre validation.' },
    };

    const selectActor = (actor) => {
        actorChoices.forEach((choice) => {
            const selected = choice.dataset.actor === actor;
            choice.setAttribute('aria-selected', selected ? 'true' : 'false');
            if (choice.classList.contains('actor-choice')) {
                choice.classList.toggle('bg-white/15', selected);
                choice.classList.toggle('border-white/30', selected);
                choice.classList.toggle('bg-white/5', !selected);
                choice.classList.toggle('border-white/15', !selected);
                choice.querySelector('.actor-check')?.classList.toggle('hidden', !selected);
            } else {
                choice.classList.toggle('border-2', selected);
                choice.classList.toggle('border-primary', selected);
                choice.classList.toggle('bg-primary/5', selected);
                choice.classList.toggle('text-primary', selected);
                choice.classList.toggle('border-outline-variant', !selected);
                choice.classList.toggle('text-on-surface-variant', !selected);
            }
        });

        const isEstablishment = actor === 'etablissement';
        establishmentForm.classList.toggle('hidden', !isEstablishment);
        doctorPanel.classList.toggle('hidden', actor !== 'medecin');
        servicePanel.classList.toggle('hidden', actor !== 'service');
        comingSoonPanel.classList.add('hidden');
        establishmentForm.querySelectorAll('input, select, textarea').forEach((field) => { field.disabled = !isEstablishment; });
        doctorPanel.querySelectorAll('input, select, textarea').forEach((field) => { field.disabled = actor !== 'medecin'; });
        servicePanel.querySelectorAll('input, select, textarea').forEach((field) => { field.disabled = actor !== 'service'; });
        formEyebrow.textContent = isEstablishment ? 'Nouvel établissement' : actorContent[actor].label;
        formTitle.textContent = isEstablishment ? 'Créer votre compte' : actor === 'medecin' ? 'Créer votre profil' : 'Parcours service';
        formDescription.textContent = isEstablishment ? 'Renseignez les informations de votre établissement pour commencer.' : actorContent[actor].description;
        if (!isEstablishment) {
            const content = actorContent[actor];
            comingSoonTitle.textContent = content.label;
            comingSoonIcon.textContent = content.icon;
            comingSoonDescription.textContent = content.description;
        }
    };

    actorChoices.forEach((choice) => choice.addEventListener('click', () => selectActor(choice.dataset.actor)));
    document.querySelector('[data-reset-actor]')?.addEventListener('click', () => selectActor('etablissement'));

    const updateSubmitState = () => {
        submitButton.disabled = !confirmationCheckbox.checked;
    };

    confirmationCheckbox.addEventListener('change', updateSubmitState);
    updateSubmitState();
</script>

</body>
</html>