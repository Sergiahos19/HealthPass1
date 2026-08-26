<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Enregistrement Patient - HealthPass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Plus+Jakarta+Sans:wght@600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#005a71",
                        "primary-container": "#0e7490",
                        "bordure-douce": "#F1F5F9",
                        "fond-page": "#F8FAFC",
                        "on-surface": "#0d1c2f",
                        "on-surface-variant": "#3f484c",
                        "error": "#ba1a1a",
                    },
                    "fontFamily": {
                        "corps-standard": ["Inter"],
                        "titre-section": ["Plus Jakarta Sans"],
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-slate-900/40 min-h-screen font-corps-standard flex items-center justify-center p-4">

    <!-- Modal Container -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col border border-slate-200">
        
        <!-- Modal Header (En-tête bleu pétrole) -->
        <div class="bg-[#0e7490] text-white px-6 py-4 flex items-center justify-between">
            <h2 class="text-xl font-bold font-titre-section">Enregistrement Patient</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-white/80 hover:text-white hover:bg-white/10 p-1.5 rounded-lg transition-colors flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">close</span>
            </a>
        </div>

        <!-- Formulaire d'enregistrement -->
        <form action="{{ route('patients.store') }}" method="POST" id="patientForm" class="p-6 space-y-6">
            @csrf

            <!-- Subtitle -->
            <p class="text-sm text-slate-500">
                Saisissez les informations d'identité du patient et enregistrez son accès biométrique sécurisé.
            </p>

            <!-- Ligne 1 : Nom et Prénom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="nom" class="block text-sm font-semibold text-slate-700">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nom" 
                        value="{{ old('nom') }}"
                        placeholder="Ex: Sergio" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e7490] focus:ring-1 focus:ring-[#0e7490] transition-colors @error('nom') border-red-500 @enderror"
                        required
                    />
                    @error('nom')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="prenom" class="block text-sm font-semibold text-slate-700">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="prenom" 
                        name="prenom" 
                        value="{{ old('prenom') }}"
                        placeholder="Ex: Sergio" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e7490] focus:ring-1 focus:ring-[#0e7490] transition-colors @error('prenom') border-red-500 @enderror"
                        required
                    />
                    @error('prenom')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <section class="space-y-4 border-t border-slate-100 pt-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Informations de santé</h3>
                    <p class="text-sm text-slate-500">Ces informations sont facultatives et doivent être renseignées avec l’accord du patient.</p>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="space-y-1.5">
                        <label for="taille" class="block text-sm font-semibold text-slate-700">Taille (m)</label>
                        <input type="number" id="taille" name="taille" value="{{ old('taille') }}" min="0.50" max="2.50" step="0.01" placeholder="1.70" class="w-full rounded-xl border border-slate-200 px-4 py-2.5" />
                        @error('taille')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="poids" class="block text-sm font-semibold text-slate-700">Poids (kg)</label>
                        <input type="number" id="poids" name="poids" value="{{ old('poids') }}" min="1" max="500" step="0.1" placeholder="70.0" class="w-full rounded-xl border border-slate-200 px-4 py-2.5" />
                        @error('poids')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="groupe_sanguin" class="block text-sm font-semibold text-slate-700">Groupe sanguin</label>
                        <select id="groupe_sanguin" name="groupe_sanguin" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5">
                            <option value="">Sélectionner</option>
                            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $groupe)
                                <option value="{{ $groupe }}" @selected(old('groupe_sanguin') === $groupe)>{{ $groupe }}</option>
                            @endforeach
                        </select>
                        @error('groupe_sanguin')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="space-y-4 border-t border-slate-100 pt-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Contact en cas d’urgence</h3>
                    <p class="text-sm text-slate-500">Une personne joignable rapidement en cas de besoin médical.</p>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="space-y-1.5"><label for="contact_urgence_nom" class="block text-sm font-semibold text-slate-700">Nom complet <span class="text-red-500">*</span></label><input type="text" id="contact_urgence_nom" name="contact_urgence_nom" value="{{ old('contact_urgence_nom') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5" />@error('contact_urgence_nom')<p class="text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div class="space-y-1.5"><label for="contact_urgence_lien" class="block text-sm font-semibold text-slate-700">Lien avec le patient <span class="text-red-500">*</span></label><input type="text" id="contact_urgence_lien" name="contact_urgence_lien" value="{{ old('contact_urgence_lien') }}" placeholder="Parent, conjoint..." required class="w-full rounded-xl border border-slate-200 px-4 py-2.5" />@error('contact_urgence_lien')<p class="text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div class="space-y-1.5"><label for="contact_urgence_telephone" class="block text-sm font-semibold text-slate-700">Téléphone <span class="text-red-500">*</span></label><input type="tel" id="contact_urgence_telephone" name="contact_urgence_telephone" value="{{ old('contact_urgence_telephone') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5" />@error('contact_urgence_telephone')<p class="text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div class="space-y-1.5"><label for="contact_urgence_email" class="block text-sm font-semibold text-slate-700">Email</label><input type="email" id="contact_urgence_email" name="contact_urgence_email" value="{{ old('contact_urgence_email') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5" />@error('contact_urgence_email')<p class="text-xs text-red-500">{{ $message }}</p>@enderror</div>
                </div>
                <div class="space-y-1.5"><label for="contact_urgence_adresse" class="block text-sm font-semibold text-slate-700">Adresse</label><textarea id="contact_urgence_adresse" name="contact_urgence_adresse" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-2.5">{{ old('contact_urgence_adresse') }}</textarea>@error('contact_urgence_adresse')<p class="text-xs text-red-500">{{ $message }}</p>@enderror</div>
            </section>

            <!-- Ligne 2 : Sexe et Date de naissance -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="sexe" class="block text-sm font-semibold text-slate-700">
                        Sexe <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="sexe" 
                        name="sexe" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 focus:outline-none focus:border-[#0e7490] focus:ring-1 focus:ring-[#0e7490] transition-colors bg-white @error('sexe') border-red-500 @enderror"
                        required
                    >
                        <option value="">Sélectionner</option>
                        <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                        <option value="X" {{ old('sexe') == 'X' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('sexe')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="date_naissance" class="block text-sm font-semibold text-slate-700">
                        Date de naissance <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="date_naissance" 
                        name="date_naissance" 
                        value="{{ old('date_naissance') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 focus:outline-none focus:border-[#0e7490] focus:ring-1 focus:ring-[#0e7490] transition-colors @error('date_naissance') border-red-500 @enderror"
                        required
                    />
                    @error('date_naissance')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ligne 3 : Email et Téléphone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-semibold text-slate-700">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="nomprenom@email.com" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e7490] focus:ring-1 focus:ring-[#0e7490] transition-colors @error('email') border-red-500 @enderror"
                        required
                    />
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="telephone" class="block text-sm font-semibold text-slate-700">
                        Téléphone
                    </label>
                    <input 
                        type="tel" 
                        id="telephone" 
                        name="telephone" 
                        value="{{ old('telephone') }}"
                        placeholder="01 58 51 18 88" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e7490] focus:ring-1 focus:ring-[#0e7490] transition-colors @error('telephone') border-red-500 @enderror"
                    />
                    @error('telephone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section Biométrie -->
            <div class="space-y-1.5 pt-2">
                <label class="block text-sm font-semibold text-slate-700">
                    Sécurité Biométrique
                </label>
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#059669]/10 text-[#059669] flex items-center justify-center">
                            <span class="material-symbols-outlined">fingerprint</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-800">Empreinte digitale</p>
                            <p class="text-xs text-slate-500">Chiffrement biométrique de bout en bout</p>
                        </div>
                    </div>
                    <button type="button" class="px-3 py-1.5 text-xs font-semibold text-[#0e7490] bg-white border border-[#0e7490]/30 rounded-lg hover:bg-[#0e7490]/10 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">scanner</span>
                        Numériser
                    </button>
                </div>
                <input type="hidden" name="biometric_data" id="biometric_data">
            </div>

            <!-- Modal Footer (Action Bouton Terminer) -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button 
                    type="submit" 
                    class="bg-[#0e7490] hover:bg-[#005a71] text-white font-semibold px-6 py-2.5 rounded-xl flex items-center gap-2 shadow-sm hover:shadow-md transition-all"
                >
                    <span class="material-symbols-outlined text-lg">check</span>
                    Enregistrer le patient
                </button>
            </div>

        </form>
    </div>

</body>
</html>