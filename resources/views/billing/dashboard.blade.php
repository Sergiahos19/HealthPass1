@extends('layouts.app')

@section('content')
<div class="mx-auto w-full max-w-7xl space-y-8 p-6 lg:p-10">
    <header class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-primary">Facturation</p>
            <h1 class="mt-2 text-3xl font-bold text-on-surface">Encaissements et factures</h1>
            <p class="mt-2 max-w-2xl text-on-surface-variant">Le caissier enregistre les actes et paiements des patients, suit les factures en attente ou réglées et conserve la preuve des encaissements.</p>
        </div>
    </header>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('success') }}</div>
    @endif

    <section class="grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-outline-variant bg-white p-5"><span class="material-symbols-outlined text-primary">receipt_long</span><h2 class="mt-3 font-bold">Créer une facture</h2><p class="mt-1 text-sm text-on-surface-variant">Associer un acte ou un service au dossier du patient.</p></div>
        <div class="rounded-xl border border-outline-variant bg-white p-5"><span class="material-symbols-outlined text-primary">payments</span><h2 class="mt-3 font-bold">Enregistrer un paiement</h2><p class="mt-1 text-sm text-on-surface-variant">Noter le montant et le moyen de règlement utilisé.</p></div>
        <div class="rounded-xl border border-outline-variant bg-white p-5"><span class="material-symbols-outlined text-primary">fact_check</span><h2 class="mt-3 font-bold">Suivre les règlements</h2><p class="mt-1 text-sm text-on-surface-variant">Consulter les factures et leur statut administratif.</p></div>
    </section>

    <section class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-xl font-bold text-on-surface">Nouvelle facture</h2>
        <form method="POST" action="{{ route('billing.store') }}" class="mt-5 grid gap-4 md:grid-cols-2">
            @csrf
            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Patient
                <select name="patient_id" required class="rounded-lg border border-outline-variant px-3 py-3">
                    <option value="">Sélectionner un patient</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id_patient }}">{{ $patient->prenom }} {{ $patient->nom }}{{ $patient->npi ? ' — '.$patient->npi : '' }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Montant (XOF)
                <input name="montant" type="number" min="0" step="0.01" required class="rounded-lg border border-outline-variant px-3 py-3">
            </label>
            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Mode de paiement
                <select name="mode_paiement" class="rounded-lg border border-outline-variant px-3 py-3">
                    <option value="">À préciser</option><option>Espèces</option><option>Mobile money</option><option>Carte</option><option>Virement</option>
                </select>
            </label>
            <label class="grid gap-2 text-sm font-semibold text-on-surface-variant">Description
                <input name="description" maxlength="1000" class="rounded-lg border border-outline-variant px-3 py-3">
            </label>
            <button class="rounded-lg bg-primary px-4 py-3 font-semibold text-white md:col-span-2 md:justify-self-end" type="submit">Enregistrer la facture</button>
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-outline-variant bg-white">
        <div class="border-b border-outline-variant px-6 py-4"><h2 class="text-xl font-bold text-on-surface">Factures récentes</h2></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-container-low text-on-surface-variant"><tr><th class="px-6 py-3">Numéro</th><th class="px-6 py-3">Patient</th><th class="px-6 py-3">Montant</th><th class="px-6 py-3">Statut</th><th class="px-6 py-3">Date</th></tr></thead>
                <tbody>
                @forelse ($factures as $facture)
                    <tr class="border-t border-outline-variant/60"><td class="px-6 py-4 font-semibold">{{ $facture->numero_facture }}</td><td class="px-6 py-4">{{ $facture->prenom }} {{ $facture->nom }}</td><td class="px-6 py-4">{{ number_format((float) $facture->montant, 0, ',', ' ') }} {{ $facture->devise }}</td><td class="px-6 py-4">{{ $facture->statut }}</td><td class="px-6 py-4">{{ \Illuminate\Support\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</td></tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-on-surface-variant">Aucune facture enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
