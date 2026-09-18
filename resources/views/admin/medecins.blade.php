<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HealthPass - Médecins</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <main class="mx-auto max-w-6xl p-6 lg:p-10">
        <header class="mb-8 flex items-center justify-between gap-4">
            <div>
                <a class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-cyan-800" href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined">arrow_back</span> Tableau de bord
                </a>
                <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-bold">Médecins</h1>
                <p class="mt-2 text-slate-600">Gérez les médecins rattachés à votre établissement.</p>
            </div>
            <span class="material-symbols-outlined text-5xl text-cyan-800">stethoscope</span>
        </header>
        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4 font-semibold">Médecins enregistrés ({{ $medecins->count() }})</div>
            @forelse ($medecins as $medecin)
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-4 last:border-0">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-cyan-800">account_circle</span>
                        <div>
                            <p class="font-semibold">{{ $medecin->prenom }} {{ $medecin->nom }}</p>
                            <p class="text-sm text-slate-600">{{ $medecin->specialite ?: 'Spécialité non renseignée' }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-slate-500">{{ $medecin->email ?: 'Email non renseigné' }}</span>
                </div>
            @empty
                <p class="px-6 py-8 text-slate-600">Aucun médecin n’est encore enregistré.</p>
            @endforelse
        </section>
    </main>
</body>
</html>
