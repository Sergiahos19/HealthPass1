<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>HealthPass - Connexion Sécurisée</title>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Tailwind Theme Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container": "#e6eeff",
                        "outline": "#6f787d",
                        "on-tertiary-container": "#a3ffd2",
                        "on-surface": "#0d1c2f",
                        "on-error": "#ffffff",
                        "on-primary-container": "#d3f1ff",
                        "surface-bright": "#f8f9ff",
                        "on-primary-fixed": "#001f29",
                        "on-error-container": "#93000a",
                        "on-secondary-fixed": "#001d31",
                        "tertiary-fixed": "#85f8c4",
                        "on-primary": "#ffffff",
                        "surface-container-highest": "#d5e3fd",
                        "surface-dim": "#ccdbf4",
                        "on-surface-variant": "#3f484c",
                        "on-background": "#0d1c2f",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#004b73",
                        "surface-container-low": "#eff4ff",
                        "on-primary-fixed-variant": "#004d62",
                        "primary-fixed-dim": "#81d1f0",
                        "primary-fixed": "#b9eaff",
                        "surface-variant": "#d5e3fd",
                        "inverse-on-surface": "#ebf1ff",
                        "secondary-container": "#5bb8fe",
                        "tertiary-container": "#007a54",
                        "on-secondary-container": "#00476e",
                        "secondary": "#006398",
                        "surface-container-high": "#dde9ff",
                        "secondary-fixed": "#cce5ff",
                        "surface": "#f8f9ff",
                        "inverse-surface": "#233144",
                        "tertiary-fixed-dim": "#68dba9",
                        "outline-variant": "#bec8cd",
                        "secondary-fixed-dim": "#93ccff",
                        "primary-container": "#0e7490",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "tertiary": "#005f41",
                        "background": "#f8f9ff",
                        "on-tertiary-fixed": "#002114",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#005a71",
                        "on-tertiary-fixed-variant": "#005137",
                        "error-container": "#ffdad6",
                        "surface-tint": "#006781",
                        "inverse-primary": "#81d1f0"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gouttiere": "16px",
                        "inter-element": "12px",
                        "inter-bloc": "32px",
                        "marge-page": "24px",
                        "unite-base": "4px"
                    },
                    "fontFamily": {
                        "mention": ["Inter", "sans-serif"],
                        "corps-sm": ["Inter", "sans-serif"],
                        "titre-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "titre-md": ["Plus Jakarta Sans", "sans-serif"],
                        "titre-xl": ["Plus Jakarta Sans", "sans-serif"],
                        "titre-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "label-bold": ["Inter", "sans-serif"],
                        "corps-lg": ["Inter", "sans-serif"],
                        "corps-md": ["Inter", "sans-serif"]
                    },
                    "fontSize": {
                        "mention": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "corps-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "titre-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "titre-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "titre-xl": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "titre-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-bold": ["14px", { "lineHeight": "20px", "fontWeight": "600" }],
                        "corps-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "corps-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .shadow-level-1 {
            box-shadow: 0px 4px 12px rgba(51, 65, 85, 0.05);
        }
        .form-input-styled {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid #bec8cd;
            border-radius: 0.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            color: #0d1c2f;
            font-size: 16px;
            line-height: 24px;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-duration: 200ms;
        }
        .form-input-styled:focus {
            outline: none;
            border-color: #005a71;
            box-shadow: 0 0 0 1px #005a71;
        }
        .form-label-styled {
            display: block;
            margin-bottom: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            line-height: 20px;
            color: #0d1c2f;
        }
    </style>
</head>
<body class="bg-background min-h-screen flex text-on-background font-corps-md antialiased">

<div class="flex flex-col md:flex-row w-full h-screen">
    <!-- Colonne Gauche: Branding & Visuel -->
    <div class="hidden md:flex flex-col w-1/2 bg-surface-tint relative overflow-hidden bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBayu7rRx45nSWJGgtCtaCHPVhdzbGFZa08WVsTClEr1OdidKmcz9KuGcKarnPY-lY6BhreqSfjCMPfLrG7e6Q08QUTtS7S9mXl3GLBVTpBBeZ8Skc5GzW1laCqy-P_6QvkYSa-s-IIZOE5wMsCf7RjZuRjsw8i_Tm_f8vW-WIdl8f_gW5AgNL9Sh7ZzE6KCYdAl_N2aciOJPxmuYv9EZ_OqM3Uh_PnVNd0h3LAAmWoA6Z2Rih5Q_AoqA')">
        <div class="absolute inset-0 bg-primary/80 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-linear-to-t from-primary to-transparent opacity-90"></div>
        <div class="relative z-10 flex h-full flex-col justify-end p-12 text-on-primary">
            <div class="mb-inter-bloc flex items-center gap-3">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">shield_locked</span>
                <h1 class="font-titre-xl text-titre-xl">HealthPass</h1>
            </div>
            <h2 class="font-titre-lg text-titre-lg mb-4">La sécurité de vos données de santé, notre priorité absolue.</h2>
            <p class="font-corps-lg text-corps-lg text-on-primary/80 max-w-xl">
                Accédez à la plateforme unifiée de gestion avec des protocoles de chiffrement de bout en bout. Chaque accès est monitoré pour garantir l'intégrité du système.
            </p>
        </div>
    </div>

    <!-- Colonne Droite: Formulaire de connexion -->
    <div class="flex-1 flex flex-col justify-center items-center p-marge-page bg-surface overflow-y-auto">
        <div class="w-full max-w-120">
            <!-- Logo Mobile -->
            <div class="md:hidden flex items-center justify-center gap-2 mb-inter-bloc text-primary">
                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                <h1 class="font-titre-md text-titre-md">HealthPass</h1>
            </div>

            <!-- Carte de Connexion -->
            <div class="bg-surface-container-lowest rounded-xl shadow-level-1 border border-outline-variant p-8 w-full relative z-10">
                <div class="mb-inter-bloc text-center">
                    <h2 class="font-titre-lg text-titre-lg text-on-surface mb-2">Connexion</h2>
                    <p class="font-corps-md text-corps-md text-on-surface-variant">
                        Veuillez vous authentifier pour accéder à votre espace de travail.
                    </p>
                </div>

                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status">
                        <span class="material-symbols-outlined shrink-0">check_circle</span>
                        <p class="font-corps-sm text-corps-sm">{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800" role="alert">
                        <p class="font-label-bold text-label-bold">Veuillez vérifier vos identifiants.</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="flex flex-col gap-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="form-label-styled" for="email">Adresse électronique</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">mail</span>
                            <input class="form-input-styled pl-12" id="email" name="email" placeholder="prenom.nom@etablissement.fr" value="{{ old('email') }}" required type="email" autocomplete="email"/>
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block font-label-bold text-label-bold text-on-surface" for="password">Mot de passe</label>
                            <a class="font-mention text-mention text-primary hover:text-primary-fixed-variant transition-colors" href="#">
                                Mot de passe oublié ?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">lock</span>
                            <input class="form-input-styled pl-12" id="password" name="password" placeholder="Votre mot de passe" required type="password" autocomplete="current-password"/>
                        </div>
                    </div>

                    <!-- Bouton Valider -->
                    <button class="mt-4 w-full bg-primary hover:bg-surface-tint text-on-primary font-label-bold text-label-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all active:scale-[0.98] shadow-sm cursor-pointer" type="submit">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">login</span>
                        Se connecter
                    </button>
                </form>
            </div>

            
            <!-- Pied de page -->
            <div class="mt-8 text-center">
                <p class="font-mention text-mention text-on-surface-variant">
                    © {{ date('Y') }} HealthPass. Ce système est réservé au personnel autorisé.
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>