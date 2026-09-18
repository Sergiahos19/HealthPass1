<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-secondary">Confidentialité renforcée</p>
            <h3 class="font-titre-section text-titre-section text-on-surface">Carnets médicaux</h3>
            <p class="mt-1 max-w-2xl text-sm text-on-surface-variant">Chaque carnet est généré à la demande avec les dernières données disponibles et envoyé uniquement à l’adresse du patient.</p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-surface-container px-3 py-2 text-xs font-semibold text-on-surface-variant"><span class="material-symbols-outlined text-base">lock</span>{{ $carnets->count() }} patient(s)</span>
    </div>
    <div class="overflow-x-auto rounded-xl border border-outline-variant/50 bg-surface">
        <table class="w-full min-w-[720px] text-left">
            <thead class="border-b border-outline-variant/40 bg-surface-container-low text-xs uppercase tracking-wide text-on-surface-variant">
                <tr><th class="px-4 py-3">Nº</th><th class="px-4 py-3">Patient</th><th class="px-4 py-3">E-mail</th><th class="px-4 py-3">Dernière activité</th><th class="px-4 py-3 text-right">Action</th></tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30">
                @forelse ($carnets as $index => $carnet)
                    <tr class="hover:bg-fond-page">
                        <td class="px-4 py-4 text-sm font-semibold text-on-surface-variant">{{ $index + 1 }}</td>
                        <td class="px-4 py-4"><p class="font-semibold">{{ $carnet->prenom }} {{ $carnet->nom }}</p><p class="text-xs text-on-surface-variant">{{ $carnet->activites }} élément(s) médical(aux)</p></td>
                        <td class="px-4 py-4 text-sm">{{ $carnet->email }}</td>
                        <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $carnet->derniere_activite ? \Illuminate\Support\Carbon::parse($carnet->derniere_activite)->format('d/m/Y H:i') : '—' }}</td>
                        <td class="px-4 py-4 text-right"><form method="POST" action="{{ route('admin.medical-records.send', $carnet->id_patient) }}" onsubmit="return confirm('Envoyer le carnet médical à ce patient ?')">@csrf<button class="inline-flex items-center gap-2 rounded-lg bg-primary px-3 py-2 text-sm font-semibold text-white hover:bg-primary-container"><span class="material-symbols-outlined text-base">send</span>Envoyer le carnet</button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-sm text-on-surface-variant">Aucun patient avec activité médicale enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
