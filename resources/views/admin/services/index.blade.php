<div class="space-y-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h2 class="font-titre-ecran text-titre-ecran text-on-surface">Services Hospitaliers</h2>
            <p class="font-corps-standard text-corps-standard text-on-surface-variant">Gérez les départements rattachés à votre établissement.</p>
        </div>
        <div class="relative w-full md:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant">search</span>
            <input class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest py-2 pl-10 pr-4 text-on-surface" placeholder="Rechercher un service..." type="search">
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div class="dashboard-card rounded-xl border border-bordure-douce bg-surface p-6">
            <div class="flex items-start justify-between">
                <div><p class="font-corps-dense text-corps-dense uppercase text-on-surface-variant">Total Services</p><h3 class="mt-2 font-titre-ecran text-titre-ecran text-primary">{{ $services->count() }}</h3></div>
                <span class="material-symbols-outlined rounded-full bg-surface-container p-3 text-primary">local_hospital</span>
            </div>
        </div>
        <div class="dashboard-card rounded-xl border border-bordure-douce bg-surface p-6">
            <div class="flex items-start justify-between">
                <div><p class="font-corps-dense text-corps-dense uppercase text-on-surface-variant">Départements actifs</p><h3 class="mt-2 font-titre-ecran text-titre-ecran text-secondary">{{ $services->count() }}</h3></div>
                <span class="material-symbols-outlined rounded-full bg-secondary-fixed p-3 text-secondary">domain</span>
            </div>
        </div>
    </div>

    @if ($serviceEdit)
        <form action="{{ route('services.update', $serviceEdit->id_service) }}" method="POST" class="dashboard-card rounded-xl border border-bordure-douce bg-surface p-6">
            @csrf @method('PUT')
            <h3 class="mb-4 font-sous-titre text-sous-titre text-on-surface">Modifier le service</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <input name="nom_service" required maxlength="100" value="{{ old('nom_service', $serviceEdit->nom_service) }}" placeholder="Nom du service" class="rounded-lg border border-outline-variant px-3 py-3">
                <input name="type_service" maxlength="100" value="{{ old('type_service', $serviceEdit->type_service) }}" placeholder="Type de service" class="rounded-lg border border-outline-variant px-3 py-3">
                <input name="telephone" maxlength="30" value="{{ old('telephone', $serviceEdit->telephone) }}" placeholder="Téléphone" class="rounded-lg border border-outline-variant px-3 py-3">
                <input name="email" type="email" maxlength="255" value="{{ old('email', $serviceEdit->email) }}" placeholder="Email contact" class="rounded-lg border border-outline-variant px-3 py-3">
            </div>
            <div class="mt-4 flex gap-3"><button class="rounded-lg bg-primary px-4 py-2 font-label-fort text-on-primary" type="submit">Enregistrer</button><a href="{{ route('admin.dashboard', ['section' => 'services']) }}" class="rounded-lg border border-outline-variant px-4 py-2 font-label-fort text-on-surface">Annuler</a></div>
        </form>
    @endif

    <div class="dashboard-card overflow-hidden rounded-xl border border-bordure-douce bg-surface">
        <div class="flex items-center justify-between border-b border-bordure-douce p-4"><h3 class="font-sous-titre text-sous-titre text-on-surface">Liste des départements</h3><span class="font-label-fort text-label-fort text-primary">{{ $services->count() }} service(s)</span></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-170 border-collapse text-left">
                <thead><tr class="border-b border-bordure-douce bg-surface-container-low font-label-fort text-label-fort text-on-surface-variant"><th class="px-6 py-4">Nom du service</th><th class="px-6 py-4">Type</th><th class="px-6 py-4">Téléphone</th><th class="px-6 py-4">Email Contact</th><th class="px-6 py-4 text-right">Actions</th></tr></thead>
                <tbody class="font-corps-dense text-corps-dense text-on-surface">
                    @forelse ($services as $service)
                        <tr class="border-b border-bordure-douce transition-colors hover:bg-fond-page">
                            <td class="px-6 py-4"><div class="flex items-center gap-3"><span class="material-symbols-outlined rounded-full bg-surface-container p-2 text-primary">local_hospital</span><span class="font-label-fort text-label-fort">{{ $service->nom_service }}</span></div></td>
                            <td class="px-6 py-4">{{ $service->type_service ?: 'Non renseigné' }}</td><td class="px-6 py-4">{{ $service->telephone ?: 'Non renseigné' }}</td><td class="px-6 py-4">{{ $service->email ?: 'Non renseigné' }}</td>
                            <td class="px-6 py-4 text-right"><a href="{{ route('admin.dashboard', ['section' => 'services', 'edit' => $service->id_service]) }}" aria-label="Modifier ce service" title="Modifier" class="rounded-lg p-2 text-secondary hover:bg-secondary-container/20"><span class="material-symbols-outlined">edit</span></a><form action="{{ route('services.destroy', $service->id_service) }}" method="POST" class="inline">@csrf @method('DELETE')<button type="submit" aria-label="Supprimer ce service" title="Supprimer" class="ml-2 rounded-lg p-2 text-error hover:bg-error-container/40"><span class="material-symbols-outlined">delete</span></button></form></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-on-surface-variant">Aucun service enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
