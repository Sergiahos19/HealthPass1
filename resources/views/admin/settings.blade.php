<div class="space-y-6">
    <div><h2 class="font-titre-ecran text-titre-ecran text-on-surface">Paramètres de l'établissement</h2><p class="mt-1 text-on-surface-variant">Modifiez les informations et les identifiants administrateur.</p></div>
    @if ($errors->any())<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6 rounded-xl border border-outline-variant/50 bg-surface-container-lowest p-6">
        @csrf @method('PUT')
        <div class="grid gap-4 sm:grid-cols-2">
            <label><span class="mb-2 block text-sm font-semibold">Nom de l'établissement</span><input name="nom_etablissement" required value="{{ old('nom_etablissement', $etablissementSettings->nom_etablissement) }}" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
            <label><span class="mb-2 block text-sm font-semibold">Téléphone</span><input name="telephone" value="{{ old('telephone', $etablissementSettings->telephone) }}" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
            <label class="sm:col-span-2"><span class="mb-2 block text-sm font-semibold">Adresse</span><input name="adresse" value="{{ old('adresse', $etablissementSettings->adresse) }}" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
            <label class="sm:col-span-2"><span class="mb-2 block text-sm font-semibold">Email de l'établissement</span><input type="email" name="email_etablissement" value="{{ old('email_etablissement', $etablissementSettings->email_etablissement) }}" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
        </div>
        <div class="border-t border-outline-variant/40 pt-5"><h3 class="font-sous-titre text-sous-titre">Identifiants de connexion</h3><div class="mt-4 grid gap-4 sm:grid-cols-2">
            <label><span class="mb-2 block text-sm font-semibold">Email de connexion</span><input type="email" name="email_connexion" required value="{{ old('email_connexion', $user->email) }}" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
            <label><span class="mb-2 block text-sm font-semibold">Mot de passe actuel</span><input type="password" name="current_password" required class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
            <label><span class="mb-2 block text-sm font-semibold">Nouveau mot de passe (facultatif)</span><input type="password" name="new_password" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
            <label><span class="mb-2 block text-sm font-semibold">Confirmation</span><input type="password" name="new_password_confirmation" class="w-full rounded-lg border border-outline-variant px-3 py-3"></label>
        </div></div>
        <div class="flex justify-end"><button class="rounded-lg bg-primary px-5 py-3 font-semibold text-on-primary" type="submit">Enregistrer les paramètres</button></div>
    </form>
</div>
