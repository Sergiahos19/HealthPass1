<!doctype html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialiser le mot de passe - HealthPass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-background px-6 text-on-background">
    <main class="w-full max-w-md rounded-2xl border border-outline-variant bg-white p-8 shadow-medical-card">
        <h1 class="text-3xl font-bold">Nouveau mot de passe</h1>
        <p class="mt-3 text-sm text-on-surface-variant">Choisissez un nouveau mot de passe d’au moins 8 caractères.</p>
        @if ($errors->any())<p class="mt-5 rounded-lg bg-red-50 p-3 text-sm text-red-800">{{ $errors->first() }}</p>@endif
        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">@csrf
            <input type="hidden" name="token" value="{{ $token }}"><input type="hidden" name="email" value="{{ $email }}">
            <label class="block text-sm font-semibold">Nouveau mot de passe<input name="password" type="password" required minlength="8" class="mt-2 w-full rounded-lg border-outline-variant" autocomplete="new-password"></label>
            <label class="block text-sm font-semibold">Confirmation<input name="password_confirmation" type="password" required minlength="8" class="mt-2 w-full rounded-lg border-outline-variant" autocomplete="new-password"></label>
            <button class="w-full rounded-lg bg-primary px-4 py-3 font-semibold text-white transition hover:bg-primary-container" type="submit">Réinitialiser</button>
        </form>
    </main>
</body>
</html>
