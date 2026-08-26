<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription médecin - HealthPass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { colors: { primary: '#005a71', 'primary-container': '#0e7490', 'on-primary': '#ffffff', 'on-surface': '#0d1c2f', 'on-surface-variant': '#3f484c', 'surface-container-low': '#eff4ff', 'surface-container-lowest': '#ffffff', 'outline-variant': '#bec8cd', error: '#ba1a1a' }, fontFamily: { corps: ['Inter'], titre: ['Plus Jakarta Sans'] } } } };</script>
</head>
<body class="min-h-screen bg-surface-container-low px-4 py-8 font-corps text-on-surface sm:px-8">
    <main class="mx-auto w-full max-w-3xl rounded-3xl bg-surface-container-lowest p-6 shadow-xl sm:p-10">
        <header class="mb-8 flex items-start justify-between gap-4 border-b border-outline-variant pb-6">
            <div><p class="mb-2 text-sm font-semibold uppercase tracking-[0.16em] text-primary">HealthPass</p><h1 class="font-titre text-3xl font-bold">Inscription médecin</h1><p class="mt-2 text-on-surface-variant">Créez votre profil professionnel et rattachez-le à votre établissement.</p></div>
            <span class="material-symbols-outlined text-4xl text-primary">stethoscope</span>
        </header>
        @if ($errors->any())<div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800" role="alert">Veuillez vérifier les informations saisies.</div>@endif
        @include('auth.partials.doctor-form')
        <a class="mt-6 flex items-center justify-center gap-2 text-sm font-semibold text-primary hover:underline" href="{{ route('register') }}"><span class="material-symbols-outlined text-lg">arrow_back</span> Choisir un autre profil</a>
    </main>
</body>
</html>
