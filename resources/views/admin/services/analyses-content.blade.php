<section class="space-y-6" aria-label="Résultats d’analyses">
    <div class="flex flex-col justify-between gap-4 border-b border-outline-variant/30 pb-6 sm:flex-row sm:items-end">
        <div>
            <p class="mb-1 font-label-fort text-label-fort uppercase tracking-[0.12em] text-secondary">{{ $service->nom_service }}</p>
            <h2 class="font-titre-ecran text-titre-ecran text-on-surface">Enregistrer un résultat</h2>
            <p class="mt-1 max-w-2xl font-corps-standard text-corps-standard text-on-surface-variant">Sélectionnez une demande médecin pour afficher automatiquement le patient, l’examen, le prescripteur et la priorité.</p>
        </div>
        <a href="{{ route('service.dashboard') }}" class="flex shrink-0 items-center gap-2 rounded-lg border border-outline-variant bg-surface px-3 py-2 font-label-fort text-label-fort text-on-surface-variant transition-colors hover:border-secondary hover:text-secondary"><span class="material-symbols-outlined">arrow_back</span>Retour au tableau de bord</a>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status"><span class="material-symbols-outlined">check_circle</span>{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-5">
        <section class="rounded-xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-carte-medicale xl:col-span-2">
            <div class="mb-5 flex items-start gap-3"><span class="material-symbols-outlined text-secondary">fact_check</span><div><h3 class="font-sous-titre text-sous-titre text-on-surface">Demande à traiter</h3><p class="mt-1 text-sm text-on-surface-variant">Les informations affichées sont verrouillées.</p></div></div>
            <form action="{{ $demandeSelectionnee ? route('service.analyses.resultat', $demandeSelectionnee->id_demande) : '#' }}" method="POST" class="space-y-5">
                @csrf @if ($demandeSelectionnee) @method('PUT') @endif
                <div><label for="demande" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Patient / demande <span class="text-error">*</span></label><select id="demande" name="demande" required class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface" onchange="if (this.value) window.location='{{ route('service.dashboard', ['section' => 'analyses']) }}&demande='+encodeURIComponent(this.value)"><option value="">Sélectionner une demande médecin</option>@foreach ($demandesPourSaisie as $demande)<option value="{{ $demande->id_demande }}" @selected($demandeSelectionnee?->id_demande === $demande->id_demande)>{{ $demande->prenom }} {{ $demande->nom }} · {{ $demande->libelle_format }}</option>@endforeach</select></div>
                @if ($demandeSelectionnee)
                    <div class="space-y-3 rounded-xl border border-secondary/20 bg-secondary/5 p-4 text-sm">
                        <div><p class="text-xs uppercase tracking-wide text-on-surface-variant">Patient</p><p class="mt-1 font-semibold text-on-surface">{{ $demandeSelectionnee->prenom }} {{ $demandeSelectionnee->nom }}</p></div>
                        <div><p class="text-xs uppercase tracking-wide text-on-surface-variant">Examen ou analyse</p><p class="mt-1 font-semibold text-on-surface">{{ $demandeSelectionnee->libelle_format }}{{ $demandeSelectionnee->type_examen ? ' · '.$demandeSelectionnee->type_examen : '' }}</p></div>
                        <div class="grid grid-cols-2 gap-3"><div><p class="text-xs uppercase tracking-wide text-on-surface-variant">Médecin demandeur</p><p class="mt-1 font-semibold text-on-surface">Dr {{ $demandeSelectionnee->docteur_prenom }} {{ $demandeSelectionnee->docteur_nom }}</p></div><div><p class="text-xs uppercase tracking-wide text-on-surface-variant">Priorité</p><p class="mt-1 font-semibold text-on-surface">{{ $demandeSelectionnee->priorite }}</p></div></div>
                    </div>
                    <div><label for="resultat" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Résultat <span class="text-error">*</span></label><textarea id="resultat" name="resultat" rows="10" required maxlength="10000" placeholder="Saisir ici le résultat complet de l’examen ou de l’analyse..." class="min-h-64 w-full resize-y rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-3 text-on-surface transition-shadow focus:border-secondary focus:outline-none focus:ring-2 focus:ring-secondary/20">{{ old('resultat') }}</textarea><p class="mt-1 text-xs text-on-surface-variant">Ce champ est obligatoire avant validation.</p></div>
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3 font-label-fort text-label-fort text-on-primary shadow-sm transition-all hover:-translate-y-0.5 hover:bg-primary-container"><span class="material-symbols-outlined">save</span>Enregistrer le résultat</button>
                @else
                    <div class="rounded-xl border border-dashed border-outline-variant bg-fond-page p-8 text-center"><span class="material-symbols-outlined text-3xl text-secondary">touch_app</span><p class="mt-2 text-sm text-on-surface-variant">Choisissez une demande pour charger ses informations.</p></div>
                @endif
            </form>
        </section>

        <section class="rounded-xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-carte-medicale xl:col-span-3">
            <div class="mb-5 flex items-center justify-between border-b border-outline-variant/30 pb-4"><div><h3 class="font-sous-titre text-sous-titre text-on-surface">Demandes reçues</h3><p class="mt-1 text-sm text-on-surface-variant">Les demandes médecin en attente de résultat.</p></div><span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-on-surface-variant">{{ $demandesPourSaisie->count() }}</span></div>
            <div class="divide-y divide-outline-variant/30">
                @forelse ($demandesPourSaisie as $demande)
                    <a href="{{ route('service.dashboard', ['section' => 'analyses', 'demande' => $demande->id_demande]) }}" class="flex items-center justify-between gap-4 py-4 transition-colors hover:bg-fond-page"><div class="flex min-w-0 items-center gap-3"><span class="material-symbols-outlined text-3xl text-secondary">account_circle</span><div class="min-w-0"><p class="truncate font-label-fort text-label-fort text-on-surface">{{ $demande->prenom }} {{ $demande->nom }}</p><p class="text-sm text-on-surface-variant">{{ $demande->libelle_format }} · Dr {{ $demande->docteur_prenom }} {{ $demande->docteur_nom }}</p></div></div><span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ in_array($demande->priorite, ['Urgente', 'STAT'], true) ? 'bg-error-container text-alerte-critique' : 'bg-surface-container text-on-surface-variant' }}">{{ $demande->priorite }}</span></a>
                @empty
                    <p class="p-10 text-center text-sm text-on-surface-variant">Aucune demande médecin en attente.</p>
                @endforelse
            </div>
        </section>
    </div>
</section>
