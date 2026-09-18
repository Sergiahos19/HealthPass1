@extends('layouts.app')

@section('content')
<div class="mx-auto w-full max-w-7xl space-y-8 p-6 lg:p-10">
    <header>
        <p class="text-sm font-semibold uppercase tracking-widest text-primary">Espace patient</p>
        <h1 class="mt-2 text-3xl font-bold text-on-surface">Bonjour {{ $patient->prenom }}</h1>
        <p class="mt-2 text-on-surface-variant">Consultez les informations partagées dans votre dossier.</p>
    </header>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-outline-variant bg-white p-6 lg:col-span-2">
            <h2 class="text-xl font-bold text-on-surface">Mon profil</h2>
            <dl class="mt-4 grid gap-4 sm:grid-cols-2 text-sm"><div><dt class="text-on-surface-variant">NPI</dt><dd class="font-semibold">{{ $patient->npi ?: 'Non renseigné' }}</dd></div><div><dt class="text-on-surface-variant">Téléphone</dt><dd class="font-semibold">{{ $patient->telephone ?: 'Non renseigné' }}</dd></div><div><dt class="text-on-surface-variant">E-mail</dt><dd class="font-semibold">{{ $patient->email ?: 'Non renseigné' }}</dd></div></dl>
        </section>
        <section class="rounded-2xl border border-outline-variant bg-white p-6"><h2 class="text-xl font-bold text-on-surface">Facturation</h2><p class="mt-4 text-3xl font-bold text-primary">{{ $factures->count() }}</p><p class="text-sm text-on-surface-variant">facture(s)</p></section>
    </div>

    <section class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-outline-variant bg-white p-6"><h2 class="text-xl font-bold">Consultations</h2><ul class="mt-4 space-y-3 text-sm">@forelse ($consultations as $consultation)<li class="border-b border-outline-variant/60 pb-3"><strong>{{ \Illuminate\Support\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</strong> — {{ $consultation->diagnostic ?: 'Compte rendu disponible auprès du médecin' }}</li>@empty<li class="text-on-surface-variant">Aucune consultation disponible.</li>@endforelse</ul></div>
        <div class="rounded-2xl border border-outline-variant bg-white p-6"><h2 class="text-xl font-bold">Prescriptions</h2><ul class="mt-4 space-y-3 text-sm">@forelse ($prescriptions as $prescription)<li class="border-b border-outline-variant/60 pb-3"><strong>{{ $prescription->medicament }}</strong> — {{ $prescription->dosage ?: 'Dosage non renseigné' }}</li>@empty<li class="text-on-surface-variant">Aucune prescription disponible.</li>@endforelse</ul></div>
    </section>
</div>
@endsection
