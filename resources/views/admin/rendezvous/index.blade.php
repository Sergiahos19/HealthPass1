<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h3 class="font-titre-lg text-titre-lg text-on-surface">Planification des consultations</h3>
            <p class="font-corps-md text-corps-md text-on-surface-variant">Gérez les disponibilités et les rendez-vous du personnel médical.</p>
        </div>
        <div class="flex items-center rounded-lg border border-outline-variant bg-surface-container-lowest p-1 shadow-sm">
            <a href="{{ route('admin.dashboard', ['section' => 'rendez-vous', 'periode' => 'today']) }}" class="rounded px-3 py-2 font-label-fort text-label-fort {{ $periode === 'today' ? 'bg-surface-variant text-on-surface' : 'text-on-surface-variant hover:text-primary' }}">Aujourd'hui</a>
            <a href="{{ route('admin.dashboard', ['section' => 'rendez-vous', 'periode' => 'week']) }}" class="rounded px-3 py-2 font-label-fort text-label-fort {{ $periode === 'week' ? 'bg-surface-variant text-on-surface' : 'text-on-surface-variant hover:text-primary' }}">Semaine</a>
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-2">
                <input type="hidden" name="section" value="rendez-vous">
                <input type="hidden" name="periode" value="date">
                <input type="date" name="date" min="{{ today()->format('Y-m-d') }}" value="{{ $periode === 'date' ? request('date') : today()->format('Y-m-d') }}" class="rounded border border-outline-variant px-2 py-1 text-sm">
                <button type="submit" class="rounded bg-primary px-3 py-2 text-xs font-semibold text-on-primary">Filtrer</button>
            </form>
        </div>
    </div>

    <div class="flex items-start gap-4 rounded-r-xl border-l-4 border-primary bg-surface-container-highest p-4">
        <span class="material-symbols-outlined mt-0.5 text-primary">privacy_tip</span>
        <div>
            <h4 class="font-label-fort text-label-fort text-on-surface">Rappel de sécurité et confidentialité</h4>
            <p class="mt-1 font-corps-dense text-corps-dense text-on-surface-variant">Cette interface affiche uniquement les métadonnées de planification. Les notes cliniques restent confidentielles.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 xl:grid-cols-12">
        <div class="flex flex-col space-y-6 xl:col-span-8">
            <div class="flex items-end justify-between">
                <h4 class="flex items-center gap-2 font-titre-md text-titre-md text-on-surface">
                    <span class="material-symbols-outlined text-primary">calendar_month</span>
                    Rendez-vous
                </h4>
                <span class="font-label-fort text-label-fort text-primary">{{ $rendezVous->count() }} rendez-vous</span>
            </div>
            <div class="overflow-hidden rounded-xl border border-outline-variant/50 bg-surface-container-lowest">
                <div class="border-b border-outline-variant/30 px-5 py-4">
                    <p class="font-label-fort text-label-fort text-on-surface">Rendez-vous</p>
                </div>
                <div class="divide-y divide-outline-variant/30">
                    @forelse ($rendezVous as $rendezVousItem)
                        <div class="flex flex-col gap-3 border-b border-bordure-douce bg-fond-page p-3 transition-colors hover:bg-surface-container-low sm:flex-row sm:items-center sm:justify-between sm:p-4">
                            <div class="flex items-center gap-4">
                                <div class="min-w-16 text-center">
                                    <p class="font-label-fort text-label-fort text-primary">{{ \Illuminate\Support\Carbon::parse($rendezVousItem->heure_rdv)->format('H:i') }}</p>
                                    <span class="font-mention text-mention text-on-surface-variant">Rendez-vous</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-3xl text-outline">account_circle</span>
                                    <div>
                                        <p class="font-label-fort text-label-fort text-on-surface">{{ $rendezVousItem->prenom }} {{ $rendezVousItem->nom }}</p>
                                        <p class="font-corps-dense text-corps-dense text-on-surface-variant">{{ $rendezVousItem->motif ?: 'Motif non renseigné' }} · Dr {{ $rendezVousItem->docteur_prenom }} {{ $rendezVousItem->docteur_nom }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                                <a href="{{ route('appointments.edit', $rendezVousItem->id_rendez_vous) }}" aria-label="Modifier ce rendez-vous" title="Modifier ce rendez-vous" class="rounded-lg p-2 text-secondary hover:bg-secondary-container/20"><span class="material-symbols-outlined">edit</span></a>
                                <form action="{{ route('appointments.destroy', $rendezVousItem->id_rendez_vous) }}" method="POST" onsubmit="return confirm('Êtes-vous vraiment sûr de vouloir supprimer ce rendez-vous ? Cette action est irréversible.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" aria-label="Supprimer ce rendez-vous" title="Supprimer" class="rounded-lg p-2 text-error hover:bg-error-container/40"><span class="material-symbols-outlined">delete</span></button>
                                </form>
                                <span class="rounded-full bg-surface-container-high px-3 py-1 text-center font-mention text-mention text-on-surface-variant">{{ $rendezVousItem->statut ?: 'Planifié' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="px-5 py-8 text-center font-corps-dense text-corps-dense text-on-surface-variant">Aucun rendez-vous prévu aujourd'hui.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-outline-variant/50 bg-surface-container-lowest p-6 xl:col-span-4">
            <div class="mb-5 flex items-center gap-3 border-b border-outline-variant/30 pb-4">
                <span class="material-symbols-outlined text-primary">add_circle</span>
                <h4 class="font-titre-sm text-titre-sm text-on-surface">{{ $rendezVousEdit ? 'Modifier le rendez-vous' : 'Nouveau rendez-vous' }}</h4>
            </div>
            <form action="{{ $rendezVousEdit ? route('appointments.update', $rendezVousEdit->id_rendez_vous) : route('appointments.store') }}" method="POST" class="space-y-4" @if ($rendezVousEdit) onsubmit="return confirm('Êtes-vous vraiment sûr de vouloir enregistrer ces modifications ? Cette action est irréversible.')" @endif>
                @csrf
                @if ($rendezVousEdit) @method('PUT') @endif
                <input type="hidden" name="periode" value="{{ $periode }}">
                <div>
                    <label class="mb-2 block font-label-fort text-label-fort text-on-surface-variant" for="patient_id">Patient</label>
                    <select id="patient_id" name="patient_id" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface">
                        <option value="">Sélectionner un patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id_patient }}" @selected(old('patient_id', $rendezVousEdit?->id_patient) === $patient->id_patient)>{{ $patient->prenom }} {{ $patient->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block font-label-fort text-label-fort text-on-surface-variant" for="doctor_id">Praticien spécialiste</label>
                    <select id="doctor_id" name="doctor_id" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface">
                        <option value="">Sélectionner un docteur</option>
                        @foreach ($medecinsRendezVous as $medecin)
                            <option value="{{ $medecin->id_docteur }}" @selected(old('doctor_id', $rendezVousEdit?->id_docteur) === $medecin->id_docteur)>Dr {{ $medecin->prenom }} {{ $medecin->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block font-label-fort text-label-fort text-on-surface-variant" for="date">Date</label>
                    <input id="date" name="date" type="date" value="{{ old('date', $rendezVousEdit?->date_rdv ? \Illuminate\Support\Carbon::parse($rendezVousEdit->date_rdv)->format('Y-m-d') : '') }}" min="{{ today()->format('Y-m-d') }}" required class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface">
                </div>
                <div>
                    <label class="mb-2 block font-label-fort text-label-fort text-on-surface-variant" for="time">Heure</label>
                    <input id="time" name="time" type="time" value="{{ old('time', $rendezVousEdit?->heure_rdv ? substr($rendezVousEdit->heure_rdv, 0, 5) : '') }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface">
                </div>
                <div>
                    <label class="mb-2 block font-label-fort text-label-fort text-on-surface-variant" for="reason">Motif administratif</label>
                    <select id="reason" name="reason" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface">
                        <option value="Consultation de suivi" @selected(old('reason', $rendezVousEdit?->motif) === 'Consultation de suivi')>Consultation de suivi</option>
                        <option value="Première consultation" @selected(old('reason', $rendezVousEdit?->motif) === 'Première consultation')>Première consultation</option>
                        <option value="Renouvellement ordonnance" @selected(old('reason', $rendezVousEdit?->motif) === 'Renouvellement ordonnance')>Renouvellement ordonnance</option>
                        <option value="Bilan annuel" @selected(old('reason', $rendezVousEdit?->motif) === 'Bilan annuel')>Bilan annuel</option>
                    </select>
                </div>
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3 font-label-fort text-label-fort text-on-primary transition-colors hover:bg-primary-container">
                    <span class="material-symbols-outlined text-[20px]">event_available</span>
                    {{ $rendezVousEdit ? 'Enregistrer les modifications' : 'Programmer' }}
                </button>
            </form>
        </div>
    </div>
</div>
