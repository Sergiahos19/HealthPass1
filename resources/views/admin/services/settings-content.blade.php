<section class="space-y-6" aria-label="Paramètres du service">
    <div>
        <p class="mb-1 font-label-fort text-label-fort uppercase tracking-[0.12em] text-secondary">Configuration du service</p>
        <h2 class="font-titre-ecran text-titre-ecran text-on-surface">Paramètres</h2>
        <p class="mt-1 font-corps-standard text-corps-standard text-on-surface-variant">Maintenez les informations opérationnelles de ce service à jour.</p>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status"><span class="material-symbols-outlined">check_circle</span>{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <section class="rounded-xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-carte-medicale xl:col-span-2">
            <h3 class="mb-1 font-sous-titre text-sous-titre text-on-surface">Informations du service</h3>
            <p class="mb-5 text-sm text-on-surface-variant">Ces informations sont visibles par les médecins et les équipes autorisées.</p>
            <form action="{{ route('service.settings.update') }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @csrf @method('PUT')
                <div><label for="nom_service" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Nom du service <span class="text-error">*</span></label><input id="nom_service" name="nom_service" required maxlength="100" value="{{ old('nom_service', $serviceSettings->nom_service) }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface"></div>
                <div><label for="type_service" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Type de service</label><input id="type_service" name="type_service" maxlength="100" value="{{ old('type_service', $serviceSettings->type_service) }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface"></div>
                <div><label for="telephone" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Téléphone</label><input id="telephone" name="telephone" maxlength="30" value="{{ old('telephone', $serviceSettings->telephone) }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface"></div>
                <div><label for="email" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Email du service</label><input id="email" name="email" type="email" maxlength="255" value="{{ old('email', $serviceSettings->email) }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface"></div>
                <div><label for="batiment" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Bâtiment</label><input id="batiment" name="batiment" maxlength="100" value="{{ old('batiment', $serviceSettings->batiment) }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface"></div>
                <div><label for="etage" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Étage</label><input id="etage" name="etage" maxlength="50" value="{{ old('etage', $serviceSettings->etage) }}" class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-3 text-on-surface"></div>
                <button type="submit" class="mt-2 flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3 font-label-fort text-label-fort text-on-primary transition-colors hover:bg-primary-container md:col-span-2"><span class="material-symbols-outlined">save</span>Enregistrer les paramètres</button>
            </form>
        </section>
        <section class="rounded-xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-carte-medicale xl:col-span-3">
            <h3 class="mb-1 font-sous-titre text-sous-titre text-on-surface">Identifiants de connexion</h3>
            <p class="mb-5 text-sm text-on-surface-variant">Modifiez l’adresse utilisée pour vous connecter et, si nécessaire, votre mot de passe.</p>
            <form action="{{ route('service.settings.update') }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @csrf @method('PUT')
                <input type="hidden" name="nom_service" value="{{ $serviceSettings->nom_service }}"><input type="hidden" name="type_service" value="{{ $serviceSettings->type_service }}"><input type="hidden" name="telephone" value="{{ $serviceSettings->telephone }}"><input type="hidden" name="email" value="{{ $serviceSettings->email }}"><input type="hidden" name="batiment" value="{{ $serviceSettings->batiment }}"><input type="hidden" name="etage" value="{{ $serviceSettings->etage }}">
                <div><label for="email_connexion" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Email de connexion <span class="text-error">*</span></label><input id="email_connexion" name="email_connexion" type="email" required value="{{ old('email_connexion', Auth::user()->email) }}" class="w-full rounded-lg border border-outline-variant px-3 py-3"></div>
                <div><label for="current_password" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Mot de passe actuel <span class="text-error">*</span></label><input id="current_password" name="current_password" type="password" required class="w-full rounded-lg border border-outline-variant px-3 py-3"></div>
                <div><label for="new_password" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Nouveau mot de passe</label><input id="new_password" name="new_password" type="password" minlength="8" class="w-full rounded-lg border border-outline-variant px-3 py-3"></div>
                <div><label for="new_password_confirmation" class="mb-2 block font-label-fort text-label-fort text-on-surface-variant">Confirmer le nouveau mot de passe</label><input id="new_password_confirmation" name="new_password_confirmation" type="password" minlength="8" class="w-full rounded-lg border border-outline-variant px-3 py-3"></div>
                <button type="submit" class="flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3 font-label-fort text-label-fort text-on-primary md:col-span-2"><span class="material-symbols-outlined">lock_reset</span>Mettre à jour les identifiants</button>
            </form>
        </section>
        <aside class="rounded-xl border border-outline-variant/50 bg-surface-container-low p-6"><span class="material-symbols-outlined mb-4 text-3xl text-secondary">verified_user</span><h3 class="font-sous-titre text-sous-titre text-on-surface">Accès sécurisé</h3><p class="mt-2 text-sm leading-6 text-on-surface-variant">Les demandes affichées dans ce service sont limitées à son établissement et à ses formats d’examen.</p><div class="mt-5 border-t border-outline-variant/40 pt-4 text-sm text-on-surface-variant"><p>Responsable</p><p class="mt-1 font-semibold text-on-surface">{{ $serviceSettings->chef_prenom }} {{ $serviceSettings->chef_nom }}</p></div></aside>
    </div>
</section>
