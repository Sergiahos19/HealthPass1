<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HealthPass — Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hp-public hp-login bg-background min-h-screen flex text-on-background font-corps-md antialiased">

<div class="flex flex-col md:flex-row w-full min-h-screen">
    <aside class="hp-login-visual hp-auth-photo hp-auth-photo--login">
        <a href="{{ route('home') }}" class="hp-brand"><span class="hp-brand-mark"><span class="material-symbols-outlined">health_and_safety</span></span>HealthPass<span class="hp-brand-dot">.</span></a>
        <div class="hp-auth-copy"><p class="hp-eyebrow">Accès professionnel sécurisé</p><h2>Reprenez votre activité médicale, là où vous l’avez laissée.</h2><p class="hp-visual-copy">Accédez aux patients, rendez-vous, consultations et analyses autorisés pour votre profil.</p><div class="hp-auth-proof"><span class="material-symbols-outlined">verified_user</span><span><strong>Session protégée</strong><small>Accès réservé au personnel autorisé</small></span></div></div>
        <p class="hp-visual-footer"><span class="material-symbols-outlined">lock</span> Données médicales confidentielles</p>
    </aside>

    <!-- Colonne Droite: Formulaire de connexion -->
    <div class="flex-1 flex flex-col justify-center items-center p-marge-page bg-surface overflow-y-auto">
        <div class="w-full max-w-120">
            <!-- Logo Mobile -->
            <div class="md:hidden flex items-center justify-center gap-2 mb-inter-bloc text-primary">
                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                <h1 class="font-titre-md text-titre-md">HealthPass</h1>
            </div>

            <a class="hp-back" href="{{ route('home') }}">← Retour à l’accueil</a>
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
                            <a class="font-mention text-mention text-primary hover:text-primary-fixed-variant transition-colors" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">lock</span>
                            <input class="form-input-styled pl-12 pr-12" id="password" name="password" placeholder="Votre mot de passe" required type="password" autocomplete="current-password"/>
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md p-1 text-on-surface-variant hover:text-primary" data-password-toggle="password" aria-label="Afficher le mot de passe" aria-pressed="false">
                                <span class="material-symbols-outlined" aria-hidden="true">visibility</span>
                            </button>
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
