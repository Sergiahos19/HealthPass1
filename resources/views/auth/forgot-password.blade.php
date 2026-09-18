<!doctype html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié - HealthPass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-background px-6 text-on-background">
    <main class="w-full max-w-md rounded-2xl border border-outline-variant bg-white p-8 shadow-medical-card">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-primary hover:underline">← Retour à la connexion</a>
        <h1 class="mt-8 text-3xl font-bold">Mot de passe oublié ?</h1>
        <p class="mt-3 text-sm leading-6 text-on-surface-variant">Saisissez votre adresse e-mail. Si elle correspond à un compte, vous recevrez un lien sécurisé.</p>
        @if (session('success'))<p class="mt-5 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800">{{ session('success') }}</p>@endif
        @if ($errors->any())<p class="mt-5 rounded-lg bg-red-50 p-3 text-sm text-red-800">{{ $errors->first() }}</p>@endif
        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">@csrf
            <label class="block text-sm font-semibold">Adresse e-mail<input name="email" type="email" required value="{{ old('email') }}" class="mt-2 w-full rounded-lg border-outline-variant" autocomplete="email"></label>
            <button class="w-full rounded-lg bg-primary px-4 py-3 font-semibold text-white transition hover:bg-primary-container" type="submit">Envoyer le lien</button>
        </form>
    </main>
</body>
</html>
