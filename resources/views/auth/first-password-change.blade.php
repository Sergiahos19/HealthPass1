<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HealthPass — Modifier le mot de passe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hp-public bg-background min-h-screen flex items-center justify-center px-6 py-12 text-on-background">
    <main class="w-full max-w-xl rounded-2xl border border-outline-variant bg-surface-container-lowest p-8 shadow-xl">
        <p class="text-sm font-semibold uppercase tracking-widest text-primary">Première connexion</p>
        <h1 class="mt-3 text-3xl font-bold text-on-surface">Sécurisez votre compte</h1>
        <p class="mt-3 text-on-surface-variant">Pour protéger vos données, vous devez remplacer le mot de passe temporaire avant d’accéder à HealthPass.</p>

        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.first-change.store') }}" class="mt-8 grid gap-5">
            @csrf
            <label class="grid gap-2 font-semibold text-on-surface">
                Nouveau mot de passe
                <input class="form-input-styled" type="password" name="password" minlength="8" required autocomplete="new-password">
            </label>
            <label class="grid gap-2 font-semibold text-on-surface">
                Confirmer le nouveau mot de passe
                <input class="form-input-styled" type="password" name="password_confirmation" minlength="8" required autocomplete="new-password">
            </label>
            <button class="rounded-lg bg-primary px-5 py-3 font-semibold text-white" type="submit">Enregistrer et continuer</button>
        </form>
    </main>
</body>
</html>
