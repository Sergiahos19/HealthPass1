<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/inscription', function () {
    $etablissements = Schema::hasTable('ETABLISSEMENT')
        ? DB::table('ETABLISSEMENT')->where('est_approuve', true)->orderBy('nom_etablissement')->get()
        : collect();

    return view('auth.register', compact('etablissements'));
})->name('register');

Route::get('/inscription/medecin', function () {
    $etablissements = Schema::hasTable('ETABLISSEMENT')
        ? DB::table('ETABLISSEMENT')->where('est_approuve', true)->orderBy('nom_etablissement')->get()
        : collect();

    return view('auth.register-doctor', compact('etablissements'));
})->name('register.doctor');

Route::get('/inscription/service', function () {
    $etablissements = Schema::hasTable('ETABLISSEMENT')
        ? DB::table('ETABLISSEMENT')->where('est_approuve', true)->orderBy('nom_etablissement')->get()
        : collect();

    return view('auth.register-service', compact('etablissements'));
})->name('register.service');

Route::post('/inscription/medecin', function (Request $request) {
    $validated = $request->validate([
        'title' => ['required', 'in:Dr.,Pr.,M.,Mme'], 'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'], 'specialty' => ['required', 'in:Médecine Générale,Cardiologie,Dermatologie,Pédiatrie,Autre'],
        'custom_specialty' => ['required_if:specialty,Autre', 'nullable', 'string', 'max:100'],
        'rpps_number' => ['nullable', 'digits:11', 'unique:DOCTEUR,rpps_number'],
        'email' => ['required', 'email', 'max:255', 'unique:DOCTEUR,email', 'unique:UTILISATEUR,email'],
        'phone' => ['nullable', 'string', 'max:30'], 'password' => ['required', 'string', 'min:8', 'confirmed'],
        'id_etablissement' => ['required', 'string', 'exists:ETABLISSEMENT,id_etablissement'],
        'confirmation' => ['accepted'],
    ]);
    DB::transaction(function () use ($validated): void {
        $userId = (string) Str::uuid();
        $doctorId = (string) Str::uuid();
        $password = Hash::make($validated['password']);
        DB::table('UTILISATEUR')->insert([
            'id_user' => $userId, 'nom' => $validated['last_name'], 'prenom' => $validated['first_name'],
            'email' => $validated['email'], 'mot_de_passe' => $password, 'id_role' => 'role-doctor',
            'id_etablissement' => $validated['id_etablissement'],
        ]);
        DB::table('DOCTEUR')->insert([
            'id_docteur' => $doctorId, 'id_user' => $userId, 'nom' => $validated['last_name'], 'prenom' => $validated['first_name'],
            'specialite' => $validated['specialty'] === 'Autre' ? $validated['custom_specialty'] : $validated['specialty'],
            'rpps_number' => $validated['rpps_number'] ?? null, 'telephone' => $validated['phone'] ?? null,
            'email' => $validated['email'], 'mot_de_passe' => $password, 'id_etablissement' => $validated['id_etablissement'],
            'est_approuve' => false,
        ]);
    });

    return to_route('login')->with('success', 'Votre profil médecin a été enregistré et rattaché à votre établissement.');
})->name('register.doctor.store');

Route::post('/inscription/service', function (Request $request) {
    $validated = $request->validate([
        'service_name' => ['required', 'string', 'max:100'], 'specialty' => ['required', 'string', 'max:100'],
        'building' => ['nullable', 'string', 'max:100'], 'floor' => ['nullable', 'string', 'max:50'],
        'head_first_name' => ['required', 'string', 'max:100'], 'head_last_name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255', 'unique:SERVICE,email', 'unique:UTILISATEUR,email'], 'phone' => ['required', 'string', 'max:30'],
        'password' => ['required', 'string', 'min:8', 'confirmed'], 'id_etablissement' => ['required', 'string', 'exists:ETABLISSEMENT,id_etablissement'],
        'confirmation' => ['accepted'],
    ]);
    DB::table('SERVICE')->insert([
        'id_service' => (string) Str::uuid(), 'nom_service' => $validated['service_name'], 'type_service' => $validated['specialty'],
        'batiment' => $validated['building'] ?? null, 'etage' => $validated['floor'] ?? null, 'chef_prenom' => $validated['head_first_name'],
        'chef_nom' => $validated['head_last_name'], 'email' => $validated['email'], 'telephone' => $validated['phone'],
        'mot_de_passe' => Hash::make($validated['password']), 'id_etablissement' => $validated['id_etablissement'],
    ]);
    $serviceId = DB::table('SERVICE')->where('email', $validated['email'])->where('id_etablissement', $validated['id_etablissement'])->value('id_service');
    DB::table('UTILISATEUR')->insert([
        'id_user' => (string) Str::uuid(), 'nom' => $validated['head_last_name'], 'prenom' => $validated['head_first_name'],
        'email' => $validated['email'], 'mot_de_passe' => Hash::make($validated['password']), 'id_role' => 'role-service',
        'id_etablissement' => $validated['id_etablissement'], 'id_service' => $serviceId,
    ]);

    return to_route('login')->with('success', 'Votre service a été enregistré et rattaché à votre établissement.');
})->name('register.service.store');

Route::post('/inscription', function (Request $request) {
    $request->validate([
        'nom_etablissement' => ['required', 'string', 'max:150'],
        'type_etablissement' => ['required', 'in:hopital,clinique,cabinet,ehpad'],
        'ifu' => ['required', 'string', 'max:30'],
        'adresse' => ['required', 'string', 'max:255'],
        'code_postal' => ['required', 'string', 'max:20'],
        'ville' => ['required', 'string', 'max:100'],
        'prenom_contact' => ['required', 'string', 'max:100'],
        'nom_contact' => ['required', 'string', 'max:100'],
        'email_contact' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'document_autorisation' => ['required', 'file', 'mimes:pdf,jpg,png', 'max:5120'],
        'photo_etablissement' => ['required', 'file', 'image', 'max:5120'],
        'confirmation_informations' => ['accepted'],
    ]);

    $etablissementId = (string) Str::uuid();
    $userId = (string) Str::uuid();

    DB::transaction(function () use ($request, $etablissementId, $userId): void {
        DB::table('ETABLISSEMENT')->insert([
            'id_etablissement' => $etablissementId,
            'nom_etablissement' => $request->string('nom_etablissement')->value(),
            'adresse' => $request->string('adresse')->value().' - '.$request->string('code_postal')->value().' '.$request->string('ville')->value(),
            'email_etablissement' => $request->string('email_contact')->value(),
            'numero_ifu' => $request->string('ifu')->value(),
            'est_approuve' => true,
        ]);

        DB::table('UTILISATEUR')->insert([
            'id_user' => $userId,
            'nom' => $request->string('nom_contact')->value(),
            'prenom' => $request->string('prenom_contact')->value(),
            'email' => $request->string('email_contact')->value(),
            'mot_de_passe' => Hash::make($request->string('password')->value()),
            'id_role' => 'role-admin',
            'id_etablissement' => $etablissementId,
        ]);
    });

    return to_route('login')->with('success', 'Votre établissement est enregistré. Vous pouvez vous connecter avec vos identifiants administrateur.');
})->name('register.store');


// Route vers la page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $email = mb_strtolower(trim($credentials['email']));

    if ($email === 'medecin@healthpass.test'
        && Schema::hasTable('ROLE')
        && Schema::hasTable('UTILISATEUR')
        && Schema::hasTable('DOCTEUR')) {
        DB::transaction(function (): void {
            DB::table('ROLE')->updateOrInsert(
                ['id_role' => 'role-doctor'],
                ['libelle_role' => 'medecin']
            );

            DB::table('UTILISATEUR')->updateOrInsert(
                ['email' => 'medecin@healthpass.test'],
                [
                    'id_user' => 'user-doctor-demo',
                    'nom' => 'Martin',
                    'prenom' => 'Claire',
                    'mot_de_passe' => Hash::make('Medecin@12345'),
                    'id_role' => 'role-doctor',
                    'id_etablissement' => 'etab-demo',
                ]
            );

            $userId = DB::table('UTILISATEUR')
                ->where('email', 'medecin@healthpass.test')
                ->value('id_user');

            $doctorData = [
                'id_docteur' => 'doctor-demo',
                'nom' => 'Martin',
                'prenom' => 'Claire',
                'specialite' => 'Médecine Générale',
                'telephone' => '+229 97 00 00 00',
                'mot_de_passe' => Hash::make('Medecin@12345'),
                'id_etablissement' => 'etab-demo',
            ];
            if (Schema::hasColumn('DOCTEUR', 'id_user')) {
                $doctorData['id_user'] = $userId;
            }
            if (Schema::hasColumn('DOCTEUR', 'est_approuve')) {
                $doctorData['est_approuve'] = true;
            }
            DB::table('DOCTEUR')->updateOrInsert(
                ['email' => 'medecin@healthpass.test'],
                $doctorData
            );
        });
    }

    $user = DB::table('UTILISATEUR')->whereRaw('LOWER(email) = ?', [$email])->first();

    // Synchronise les anciennes demandes médecin qui n'avaient pas encore de compte de connexion.
    if (! $user && Schema::hasTable('DOCTEUR') && Schema::hasColumn('DOCTEUR', 'id_user')) {
        $doctor = DB::table('DOCTEUR')->whereRaw('LOWER(email) = ?', [$email])->first();
        if ($doctor && $doctor->mot_de_passe) {
            $userId = (string) Str::uuid();
            DB::table('UTILISATEUR')->insert([
                'id_user' => $userId,
                'nom' => $doctor->nom,
                'prenom' => $doctor->prenom,
                'email' => $email,
                'mot_de_passe' => $doctor->mot_de_passe,
                'id_role' => 'role-doctor',
                'id_etablissement' => $doctor->id_etablissement,
            ]);
            DB::table('DOCTEUR')->where('id_docteur', $doctor->id_docteur)->update(['id_user' => $userId]);
            $user = DB::table('UTILISATEUR')->where('id_user', $userId)->first();
        }
    }

    if (! $user || ! Hash::check($credentials['password'], $user->mot_de_passe)) {
        Auth::logout();
        return back()->withErrors(['email' => 'Les identifiants sont incorrects.'])
            ->onlyInput('email');
    }

    $authenticatedUser = (new \App\Models\User)->newFromBuilder((array) $user);
    if ($authenticatedUser->isDoctor()
        && Schema::hasColumn('DOCTEUR', 'id_user')
        && Schema::hasColumn('DOCTEUR', 'est_approuve')
        && ! DB::table('DOCTEUR')->where('id_user', $user->id_user)->where('est_approuve', true)->exists()) {
        Auth::logout();
        return back()->withErrors(['email' => 'Votre demande médecin n’a pas encore été approuvée.'])
            ->onlyInput('email');
    }
    if (! in_array($authenticatedUser->id_role, ['role-admin', 'role-service', 'role-doctor'], true)) {
        Auth::logout();
        return back()->withErrors(['email' => 'Les identifiants sont incorrects.'])->onlyInput('email');
    }

    Auth::login($authenticatedUser, $request->boolean('remember'));
    $request->session()->regenerate();

    return $authenticatedUser->isDoctor() ? to_route('doctor.dashboard') : ($authenticatedUser->isService() ? to_route('service.dashboard') : to_route('admin.dashboard'));
})->name('login.store');


Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('home');
})->middleware('auth')->name('logout');

Route::get('/service/dashboard', function () {
    abort_unless(Auth::user()?->isService(), 403);
    abort_unless(Schema::hasTable('SERVICE'), 503);

    $service = DB::table('SERVICE')->where('id_service', Auth::user()->id_service)->where('id_etablissement', Auth::user()->id_etablissement)->first();
    abort_unless($service, 404);
    $demandes = Schema::hasTable('RESULTAT_SERVICE')
        ? DB::table('RESULTAT_SERVICE')->where('id_format', function ($query) use ($service): void {
            $query->select('id_format')->from('FORMAT')->where('id_service', $service->id_service);
        })->count()
        : 0;
    $demandesRecentes = Schema::hasTable('RESULTAT_SERVICE') && Schema::hasTable('FORMAT')
        ? DB::table('RESULTAT_SERVICE')
            ->join('FORMAT', 'FORMAT.id_format', '=', 'RESULTAT_SERVICE.id_format')
            ->join('CONSULTATION', 'CONSULTATION.id_consultation', '=', 'RESULTAT_SERVICE.id_consultation')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'CONSULTATION.id_patient')
            ->leftJoin('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'CONSULTATION.id_docteur')
            ->where('FORMAT.id_service', $service->id_service)->latest('RESULTAT_SERVICE.date_resultat')->limit(5)
            ->select('RESULTAT_SERVICE.*', 'FORMAT.libelle_format', 'PATIENT.nom', 'PATIENT.prenom', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->get()
        : collect();
    $urgentes = $demandesRecentes->where('statut', 'Urgent')->count();
    $traitees = $demandesRecentes->whereIn('statut', ['Traité', 'Traitee', 'Terminé'])->count();
    $formats = Schema::hasTable('FORMAT')
        ? DB::table('FORMAT')->where('id_service', $service->id_service)->select('type_examen')->selectRaw('count(*) as total')->groupBy('type_examen')->get()
        : collect();
    $formatsTotal = max(1, $formats->sum('total'));

    return view('admin.services.dashboard', compact('service', 'demandes', 'demandesRecentes', 'urgentes', 'traitees', 'formats', 'formatsTotal'));
})->middleware('auth')->name('service.dashboard');

$doctorForAuthenticatedUser = static function (): object {
    $user = Auth::user();
    abort_unless($user?->isDoctor(), 403);

    $query = DB::table('DOCTEUR')
        ->join('ETABLISSEMENT', 'ETABLISSEMENT.id_etablissement', '=', 'DOCTEUR.id_etablissement')
        ->where('DOCTEUR.id_etablissement', $user->id_etablissement)
        ->select('DOCTEUR.*', 'ETABLISSEMENT.nom_etablissement');

    if (Schema::hasColumn('DOCTEUR', 'id_user')) {
        $query->where('DOCTEUR.id_user', $user->id_user);
    } else {
        $query->whereRaw('LOWER(DOCTEUR.email) = ?', [mb_strtolower($user->email)]);
    }
    if (Schema::hasColumn('DOCTEUR', 'est_approuve')) {
        $query->where('DOCTEUR.est_approuve', true);
    }

    $doctor = $query->first();
    abort_unless($doctor, 403);

    return $doctor;
};

Route::get('/medecin/dashboard', function () use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    $etablissementId = Auth::user()->id_etablissement;
    $section = request()->string('section', 'home')->value();
    $allowedSections = ['home', 'patients', 'consultations', 'analyses', 'settings'];
    if (! in_array($section, $allowedSections, true)) {
        $section = 'home';
    }

    $patientsQuery = DB::table('PATIENT')->where('id_etablissement', $etablissementId);
    $patientsTotal = (clone $patientsQuery)->count();
    $patientsHommes = (clone $patientsQuery)->where('sexe', 'M')->count();
    $patientsFemmes = (clone $patientsQuery)->where('sexe', 'F')->count();
    $patientsNouveaux = Schema::hasColumn('PATIENT', 'created_at')
        ? (clone $patientsQuery)->whereDate('created_at', today())->count()
        : 0;

    $search = request()->string('search')->trim()->value();
    $sexe = request()->string('sexe')->value();
    $groupeSanguin = request()->string('groupe_sanguin')->value();
    $datePeriod = request()->string('date_period')->value();
    $dateFrom = request()->string('date_from')->value();
    $dateTo = request()->string('date_to')->value();
    if ($search !== '') {
        $patientsQuery->where(function ($query) use ($search): void {
            $term = '%'.$search.'%';
            $query->where('nom', 'like', $term)->orWhere('prenom', 'like', $term)
                ->orWhere('email', 'like', $term)->orWhere('telephone', 'like', $term);
        });
    }
    if (in_array($sexe, ['M', 'F', 'X'], true)) {
        $patientsQuery->where('sexe', $sexe);
    }
    if (in_array($groupeSanguin, ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'], true)) {
        $patientsQuery->where('groupe_sanguin', $groupeSanguin);
    }
    if (in_array($datePeriod, ['today', 'yesterday', 'month', 'custom'], true) && Schema::hasTable('RENDEZ_VOUS')) {
        if ($datePeriod === 'today') {
            $dateFrom = $dateTo = today()->toDateString();
        } elseif ($datePeriod === 'yesterday') {
            $dateFrom = $dateTo = today()->subDay()->toDateString();
        } elseif ($datePeriod === 'month') {
            $dateFrom = today()->startOfMonth()->toDateString();
            $dateTo = today()->endOfMonth()->toDateString();
        }
        $patientsQuery->whereExists(function ($query) use ($doctor, $etablissementId, $dateFrom, $dateTo): void {
            $query->selectRaw('1')->from('RENDEZ_VOUS')
                ->whereColumn('RENDEZ_VOUS.id_patient', 'PATIENT.id_patient')
                ->where('RENDEZ_VOUS.id_docteur', $doctor->id_docteur)
                ->where('RENDEZ_VOUS.id_etablissement', $etablissementId)
                ->whereBetween('RENDEZ_VOUS.date_rdv', [$dateFrom, $dateTo]);
        });
    }
    $patients = $patientsQuery->orderBy('nom')->orderBy('prenom')->get();

    $patientFocus = null;
    $consultationsPatient = collect();
    $analysesPatient = collect();
    $selectedPatientId = request()->string('patient')->value();
    if ($section === 'consultations' && $selectedPatientId === '' && Schema::hasTable('RENDEZ_VOUS')) {
        $selectedPatientId = (string) DB::table('RENDEZ_VOUS')
            ->where('id_docteur', $doctor->id_docteur)
            ->where('id_etablissement', $etablissementId)
            ->whereDate('date_rdv', today())
            ->orderBy('heure_rdv')
            ->value('id_patient');
    }
    if ($selectedPatientId !== '') {
        $patientFocus = DB::table('PATIENT')->where('id_patient', $selectedPatientId)
            ->where('id_etablissement', $etablissementId)->first();
        abort_unless($patientFocus, 404);
        if (Schema::hasTable('CONSULTATION')) {
            $consultationsPatientQuery = DB::table('CONSULTATION')
                ->where('id_patient', $patientFocus->id_patient)->where('id_docteur', $doctor->id_docteur);
            if (Schema::hasColumn('CONSULTATION', 'id_etablissement')) {
                $consultationsPatientQuery->where('id_etablissement', $etablissementId);
            }
            $consultationsPatient = $consultationsPatientQuery->latest('date_consultation')->latest('heure')->get();
        }
        if (Schema::hasTable('ANALYSE')) {
            $analysesPatientQuery = DB::table('ANALYSE')
                ->leftJoin('SERVICE', 'SERVICE.id_service', '=', 'ANALYSE.id_service')
                ->where('ANALYSE.id_patient', $patientFocus->id_patient)
                ->where('ANALYSE.id_docteur', $doctor->id_docteur);
            if (Schema::hasColumn('ANALYSE', 'id_etablissement')) {
                $analysesPatientQuery->where('ANALYSE.id_etablissement', $etablissementId);
            }
            $analysesPatient = $analysesPatientQuery->select('ANALYSE.*', 'SERVICE.nom_service')->latest('date_analyse')->get();
        }
    }
    $prescriptionsPatient = Schema::hasTable('PRESCRIPTION')
        ? DB::table('PRESCRIPTION')->where('id_patient', $patientFocus?->id_patient)
            ->where('id_docteur', $doctor->id_docteur)->latest('date_prescription')->get()
        : collect();

    $todayAppointments = Schema::hasTable('RENDEZ_VOUS')
        ? DB::table('RENDEZ_VOUS')->join('PATIENT', 'PATIENT.id_patient', '=', 'RENDEZ_VOUS.id_patient')
            ->where('RENDEZ_VOUS.id_docteur', $doctor->id_docteur)
            ->where('RENDEZ_VOUS.id_etablissement', $etablissementId)->whereDate('RENDEZ_VOUS.date_rdv', today())
            ->select('RENDEZ_VOUS.*', 'PATIENT.nom', 'PATIENT.prenom', 'PATIENT.sexe', 'PATIENT.groupe_sanguin')
            ->orderBy('heure_rdv')->get()
        : collect();
    if ($section === 'consultations' && request()->filled('patient')) {
        $selectedPatient = request()->string('patient')->value();
        $todayAppointments = $todayAppointments->sortByDesc(
            fn ($appointment): bool => $appointment->id_patient === $selectedPatient
        )->values();
    }
    $todayConsultations = Schema::hasTable('CONSULTATION')
        ? DB::table('CONSULTATION')->where('id_docteur', $doctor->id_docteur)
            ->when(Schema::hasColumn('CONSULTATION', 'id_etablissement'), fn ($query) => $query->where('id_etablissement', $etablissementId))
            ->whereDate('date_consultation', today())->count()
        : 0;
    $todayAnalyses = Schema::hasTable('ANALYSE')
        ? DB::table('ANALYSE')->where('id_docteur', $doctor->id_docteur)
            ->when(Schema::hasColumn('ANALYSE', 'id_etablissement'), fn ($query) => $query->where('id_etablissement', $etablissementId))
            ->whereDate('date_analyse', today())->count()
        : 0;
    $services = Schema::hasTable('SERVICE')
        ? DB::table('SERVICE')->where('id_etablissement', $etablissementId)->orderBy('nom_service')->get()
        : collect();
    $recentConsultations = Schema::hasTable('CONSULTATION')
        ? DB::table('CONSULTATION')->join('PATIENT', 'PATIENT.id_patient', '=', 'CONSULTATION.id_patient')
            ->where('CONSULTATION.id_docteur', $doctor->id_docteur)
            ->when(Schema::hasColumn('CONSULTATION', 'id_etablissement'), fn ($query) => $query->where('CONSULTATION.id_etablissement', $etablissementId))
            ->select('CONSULTATION.*', 'PATIENT.nom', 'PATIENT.prenom')->latest('date_consultation')->latest('heure')->limit(5)->get()
        : collect();

    return view('admin.docteur.dashboard', compact(
        'doctor', 'section', 'patients', 'patientsTotal', 'patientsHommes', 'patientsFemmes', 'patientsNouveaux',
        'search', 'sexe', 'groupeSanguin', 'datePeriod', 'dateFrom', 'dateTo', 'patientFocus', 'consultationsPatient',
        'analysesPatient', 'prescriptionsPatient', 'todayAppointments', 'todayConsultations', 'todayAnalyses', 'services', 'recentConsultations'
    ));
})->middleware('auth')->name('doctor.dashboard');

Route::post('/medecin/prescriptions', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    abort_unless(Schema::hasTable('PRESCRIPTION'), 503);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'medicaments' => ['required', 'array', 'min:1'],
        'medicaments.*.medicament' => ['required', 'string', 'max:150'],
        'medicaments.*.dosage' => ['nullable', 'string', 'max:100'],
        'medicaments.*.duree_jours' => ['nullable', 'integer', 'min:1', 'max:3650'],
        'medicaments.*.frequence' => ['nullable', 'string', 'max:100'],
        'medicaments.*.quantite' => ['nullable', 'integer', 'min:1', 'max:10000'],
    ]);
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])
        ->where('id_etablissement', Auth::user()->id_etablissement)->exists(), 404);

    DB::transaction(function () use ($validated, $doctor): void {
        foreach ($validated['medicaments'] as $medicament) {
            DB::table('PRESCRIPTION')->insert([
                'id_prescription' => (string) Str::uuid(),
                'id_patient' => $validated['patient_id'],
                'id_docteur' => $doctor->id_docteur,
                'id_etablissement' => Auth::user()->id_etablissement,
                'medicament' => $medicament['medicament'],
                'dosage' => $medicament['dosage'] ?? null,
                'duree_jours' => $medicament['duree_jours'] ?? null,
                'frequence' => $medicament['frequence'] ?? null,
                'quantite' => $medicament['quantite'] ?? null,
                'date_prescription' => today(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    });

    return to_route('doctor.patients.show', $validated['patient_id'])
        ->with('success', 'La prescription a été enregistrée.');
})->middleware('auth')->name('doctor.prescriptions.store');

foreach ([
    'patients' => 'patients',
    'consultations' => 'consultations',
    'analyses' => 'analyses',
    'settings' => 'settings',
] as $doctorSection => $doctorRouteName) {
    Route::get('/medecin/'.$doctorSection, function () use ($doctorSection) {
        $parameters = ['section' => $doctorSection];
        if (request()->filled('patient')) {
            $parameters['patient'] = request()->string('patient')->value();
        }

        return to_route('doctor.dashboard', $parameters);
    })->middleware('auth')->name('doctor.'.$doctorRouteName);
}

Route::get('/medecin/patients/{id}', function (string $id) use ($doctorForAuthenticatedUser) {
    $doctorForAuthenticatedUser();
    abort_unless(DB::table('PATIENT')->where('id_patient', $id)->where('id_etablissement', Auth::user()->id_etablissement)->exists(), 404);
    return to_route('doctor.dashboard', ['section' => 'patients', 'patient' => $id]);
})->middleware('auth')->name('doctor.patients.show');

Route::get('/medecin/patients/{id}/edit', function (string $id) use ($doctorForAuthenticatedUser) {
    $doctorForAuthenticatedUser();
    abort_unless(DB::table('PATIENT')->where('id_patient', $id)->where('id_etablissement', Auth::user()->id_etablissement)->exists(), 404);
    return to_route('doctor.dashboard', ['section' => 'patients', 'patient' => $id, 'edit' => 1]);
})->middleware('auth')->name('doctor.patients.edit');

Route::put('/medecin/patients/{id}', function (Request $request, string $id) use ($doctorForAuthenticatedUser) {
    $doctorForAuthenticatedUser();
    $patient = DB::table('PATIENT')->where('id_patient', $id)->where('id_etablissement', Auth::user()->id_etablissement)->first();
    abort_unless($patient, 404);
    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'], 'prenom' => ['required', 'string', 'max:100'],
        'sexe' => ['required', 'in:M,F,X'], 'date_naissance' => ['required', 'date', 'before:today'],
        'email' => ['nullable', 'email', 'max:255', Rule::unique('PATIENT', 'email')->ignore($id, 'id_patient')],
        'telephone' => ['nullable', 'string', 'max:30'], 'taille' => ['nullable', 'numeric', 'min:0.5', 'max:2.5'],
        'poids' => ['nullable', 'numeric', 'min:1', 'max:500'], 'groupe_sanguin' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
        'contact_urgence_nom' => ['nullable', 'string', 'max:150'], 'contact_urgence_lien' => ['nullable', 'string', 'max:80'],
        'contact_urgence_telephone' => ['nullable', 'string', 'max:30'], 'contact_urgence_email' => ['nullable', 'email', 'max:255'],
        'contact_urgence_adresse' => ['nullable', 'string', 'max:500'],
    ]);
    $patientData = $validated;
    if (Schema::hasColumn('PATIENT', 'updated_at')) {
        $patientData['updated_at'] = now();
    }
    DB::table('PATIENT')->where('id_patient', $id)->update($patientData);
    return to_route('doctor.dashboard', ['section' => 'patients', 'patient' => $id])->with('success', 'Le dossier patient a été mis à jour.');
})->middleware('auth')->name('doctor.patients.update');

Route::delete('/medecin/patients/{id}', function (string $id) use ($doctorForAuthenticatedUser) {
    $doctorForAuthenticatedUser();
    $deleted = DB::table('PATIENT')->where('id_patient', $id)->where('id_etablissement', Auth::user()->id_etablissement)->delete();
    abort_unless($deleted, 404);
    return to_route('doctor.dashboard', ['section' => 'patients'])->with('success', 'Le patient a été supprimé.');
})->middleware('auth')->name('doctor.patients.destroy');

Route::post('/medecin/consultations', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    abort_unless(Schema::hasTable('CONSULTATION'), 503);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'appointment_id' => ['nullable', 'string', 'exists:RENDEZ_VOUS,id_rendez_vous'],
        'motif' => ['nullable', 'string', 'max:1000'], 'symptomes' => ['nullable', 'string', 'max:5000'],
        'diagnostic' => ['nullable', 'string', 'max:5000'], 'traitement' => ['nullable', 'string', 'max:5000'],
        'observation_medicale' => ['nullable', 'string', 'max:5000'],
    ]);
    $appointment = DB::table('RENDEZ_VOUS')
        ->where('id_docteur', $doctor->id_docteur)->where('id_etablissement', Auth::user()->id_etablissement)
        ->whereDate('date_rdv', today())->where('id_patient', $validated['patient_id'])
        ->when($validated['appointment_id'] ?? null, fn ($query, $appointmentId) => $query->where('id_rendez_vous', $appointmentId))
        ->orderBy('heure_rdv')->first();
    abort_unless($appointment && $appointment->id_patient === $validated['patient_id'], 422);
    $data = [
        'id_consultation' => (string) Str::uuid(), 'date_consultation' => today(), 'heure' => now()->format('H:i:s'),
        'motif' => $validated['motif'] ?? null, 'symptomes' => $validated['symptomes'] ?? null,
        'diagnostic' => $validated['diagnostic'] ?? null, 'traitement' => $validated['traitement'] ?? null,
        'observation_medicale' => $validated['observation_medicale'] ?? null, 'id_patient' => $validated['patient_id'],
        'id_docteur' => $doctor->id_docteur,
    ];
    if (Schema::hasColumn('CONSULTATION', 'id_etablissement')) $data['id_etablissement'] = Auth::user()->id_etablissement;
    if (Schema::hasColumn('CONSULTATION', 'id_rendez_vous')) $data['id_rendez_vous'] = $appointment->id_rendez_vous;
    if (Schema::hasColumn('CONSULTATION', 'created_at')) $data['created_at'] = now();
    if (Schema::hasColumn('CONSULTATION', 'updated_at')) $data['updated_at'] = now();
    DB::table('CONSULTATION')->insert($data);
    DB::table('RENDEZ_VOUS')->where('id_rendez_vous', $appointment->id_rendez_vous)->update(['statut' => 'Terminé', 'updated_at' => now()]);
    return to_route('doctor.dashboard', ['section' => 'consultations'])->with('success', 'La consultation a été enregistrée.');
})->middleware('auth')->name('doctor.consultations.store');

Route::post('/medecin/analyses', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    abort_unless(Schema::hasTable('ANALYSE') && Schema::hasTable('SERVICE'), 503);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'appointment_id' => ['nullable', 'string', 'exists:RENDEZ_VOUS,id_rendez_vous'],
        'service_id' => ['required', 'string', 'exists:SERVICE,id_service'],
        'type_analyse' => ['required', 'string', 'max:150'], 'prescription' => ['nullable', 'string', 'max:5000'],
        'observation' => ['nullable', 'string', 'max:5000'], 'priorite' => ['required', 'in:Normale,Urgente'],
    ]);
    $appointment = DB::table('RENDEZ_VOUS')
        ->where('id_docteur', $doctor->id_docteur)->where('id_etablissement', Auth::user()->id_etablissement)
        ->whereDate('date_rdv', today())->where('id_patient', $validated['patient_id'])
        ->when($validated['appointment_id'] ?? null, fn ($query, $appointmentId) => $query->where('id_rendez_vous', $appointmentId))
        ->orderBy('heure_rdv')->first();
    $service = DB::table('SERVICE')->where('id_service', $validated['service_id'])
        ->where('id_etablissement', Auth::user()->id_etablissement)->first();
    abort_unless($appointment && $service, 422);
    $data = [
        'id_analyse' => (string) Str::uuid(), 'date_analyse' => today(), 'type_analyse' => $validated['type_analyse'],
        'prescription' => $validated['prescription'] ?? null, 'observation' => $validated['observation'] ?? null,
        'statut' => 'Prescrite', 'priorite' => $validated['priorite'], 'id_patient' => $validated['patient_id'],
        'id_docteur' => $doctor->id_docteur, 'id_service' => $service->id_service,
    ];
    if (Schema::hasColumn('ANALYSE', 'id_etablissement')) $data['id_etablissement'] = Auth::user()->id_etablissement;
    if (Schema::hasColumn('ANALYSE', 'id_rendez_vous')) $data['id_rendez_vous'] = $appointment->id_rendez_vous;
    if (Schema::hasColumn('ANALYSE', 'created_at')) $data['created_at'] = now();
    if (Schema::hasColumn('ANALYSE', 'updated_at')) $data['updated_at'] = now();
    DB::table('ANALYSE')->insert($data);
    return to_route('doctor.dashboard', ['section' => 'analyses'])->with('success', 'La demande d’analyse a été enregistrée.');
})->middleware('auth')->name('doctor.analyses.store');

Route::put('/medecin/parametres', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'], 'prenom' => ['required', 'string', 'max:100'],
        'specialite' => ['nullable', 'string', 'max:100'], 'telephone' => ['nullable', 'string', 'max:30'],
        'email' => ['required', 'email', 'max:255'], 'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);
    $emailTaken = DB::table('DOCTEUR')->whereRaw('LOWER(email) = ?', [mb_strtolower($validated['email'])])
        ->where('id_docteur', '!=', $doctor->id_docteur)->exists();
    if (! $emailTaken && Schema::hasTable('UTILISATEUR')) {
        $emailTaken = DB::table('UTILISATEUR')->whereRaw('LOWER(email) = ?', [mb_strtolower($validated['email'])])
            ->when(Schema::hasColumn('DOCTEUR', 'id_user') && $doctor->id_user, fn ($query) => $query->where('id_user', '!=', $doctor->id_user))
            ->exists();
    }
    abort_if($emailTaken, 422, 'Cette adresse email est déjà utilisée.');
    $doctorData = collect($validated)->except('password')->all();
    DB::table('DOCTEUR')->where('id_docteur', $doctor->id_docteur)->update($doctorData);
    if (Schema::hasColumn('DOCTEUR', 'id_user') && $doctor->id_user) {
        $userData = ['nom' => $validated['nom'], 'prenom' => $validated['prenom'], 'email' => $validated['email']];
        if (! empty($validated['password'])) $userData['mot_de_passe'] = Hash::make($validated['password']);
        DB::table('UTILISATEUR')->where('id_user', $doctor->id_user)->update($userData);
    }
    return to_route('doctor.dashboard', ['section' => 'settings'])->with('success', 'Vos paramètres ont été enregistrés.');
})->middleware('auth')->name('doctor.settings.update');

Route::get('/admin/patients/create', function () {
    abort_unless(Auth::user()?->isAdministrator(), 403);

    return view('admin.patients.create');
})->middleware('auth')->name('patients.create');

Route::post('/admin/patients', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);

    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'],
        'prenom' => ['required', 'string', 'max:100'],
        'sexe' => ['required', 'in:M,F,X'],
        'date_naissance' => ['required', 'date', 'before:today'],
        'email' => ['required', 'email', 'max:255', 'unique:PATIENT,email'],
        'telephone' => ['nullable', 'string', 'max:30'],
        'taille' => ['nullable', 'numeric', 'min:0.5', 'max:2.5'],
        'poids' => ['nullable', 'numeric', 'min:1', 'max:500'],
        'groupe_sanguin' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
        'contact_urgence_nom' => ['required', 'string', 'max:150'],
        'contact_urgence_lien' => ['required', 'string', 'max:80'],
        'contact_urgence_telephone' => ['required', 'string', 'max:30'],
        'contact_urgence_email' => ['nullable', 'email', 'max:255'],
        'contact_urgence_adresse' => ['nullable', 'string', 'max:500'],
        'biometric_data' => ['nullable', 'string'],
    ]);

    $validated['id_patient'] = (string) Str::uuid();
    $validated['id_etablissement'] = Auth::user()->id_etablissement;
    $validated['empreinte_digitale'] = $validated['biometric_data'] ?? null;
    unset($validated['biometric_data']);

    DB::table('PATIENT')->insert($validated);

    return to_route('admin.dashboard', ['section' => 'patients'])
        ->with('success', 'Le patient a été enregistré avec succès.');
})->middleware('auth')->name('patients.store');

// Route Tableau de bord Administrateur
Route::get('/admin/dashboard', function () {
    abort_unless(Auth::user()?->isAdministrator(), 403);

    $user = Auth::user();
    $etablissementId = $user->id_etablissement;
    $etablissement = DB::table('ETABLISSEMENT')->where('id_etablissement', $etablissementId)->first();
    $periode = request()->string('periode', 'today')->value();
    $dateDebut = today();
    $dateFin = $periode === 'week' ? today()->endOfWeek() : today();
    $rendezVous = Schema::hasTable('RENDEZ_VOUS')
        ? DB::table('RENDEZ_VOUS')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'RENDEZ_VOUS.id_patient')
            ->join('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'RENDEZ_VOUS.id_docteur')
            ->where('RENDEZ_VOUS.id_etablissement', $etablissementId)
            ->whereBetween('date_rdv', [$dateDebut, $dateFin])
            ->orderBy('date_rdv')->orderBy('heure_rdv')
            ->select('RENDEZ_VOUS.*', 'PATIENT.nom', 'PATIENT.prenom', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->get()
        : collect();
    $patientsRecents = Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->where('id_etablissement', $etablissementId)->latest('id_patient')->limit(5)->get()
        : collect();
    $patientsCount = Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->where('id_etablissement', $etablissementId)->count()
        : 0;
    $medecinsCount = Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->where('id_etablissement', $etablissementId)->count()
        : 0;
    $section = request()->string('section')->value();
    $medecins = $section === 'medecins' && Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->where('id_etablissement', $etablissementId)->orderBy('nom')->get()
        : collect();
    $medecinEdit = $section === 'medecins' && request()->filled('edit') && Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->where('id_docteur', request()->string('edit')->value())->where('id_etablissement', $etablissementId)->first()
        : null;
    $salleAttente = Schema::hasTable('SALLE_ATTENTE')
        ? DB::table('SALLE_ATTENTE')->join('PATIENT', 'PATIENT.id_patient', '=', 'SALLE_ATTENTE.id_patient')
            ->where('SALLE_ATTENTE.id_etablissement', $etablissementId)->where('SALLE_ATTENTE.statut', 'En attente')
            ->orderBy('arrivee_at')->select('SALLE_ATTENTE.*', 'PATIENT.nom', 'PATIENT.prenom')->get()
        : collect();
    $patients = $section === 'rendez-vous' && Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->where('id_etablissement', $etablissementId)->orderBy('nom')->orderBy('prenom')->get()
        : collect();
    $medecinsRendezVous = $section === 'rendez-vous' && Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->where('id_etablissement', $etablissementId)->orderBy('nom')->orderBy('prenom')->get()
        : collect();
    $rendezVousEdit = $section === 'rendez-vous' && request()->filled('edit')
        ? DB::table('RENDEZ_VOUS')->where('id_rendez_vous', request()->string('edit')->value())->where('id_etablissement', $etablissementId)->first()
        : null;
    $services = $section === 'services' && Schema::hasTable('SERVICE')
        ? DB::table('SERVICE')->where('id_etablissement', $etablissementId)->orderBy('nom_service')->get()
        : collect();
    $serviceEdit = $section === 'services' && request()->filled('edit') && Schema::hasTable('SERVICE')
        ? DB::table('SERVICE')->where('id_service', request()->string('edit')->value())->where('id_etablissement', $etablissementId)->first()
        : null;

    return view('admin.dashboard', compact('user', 'etablissement', 'rendezVous', 'patientsRecents', 'patientsCount', 'medecinsCount', 'section', 'medecins', 'medecinEdit', 'patients', 'medecinsRendezVous', 'periode', 'rendezVousEdit', 'services', 'serviceEdit', 'salleAttente'));
})->middleware('auth')->name('admin.dashboard');

Route::post('/admin/rendez-vous', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'doctor_id' => ['required', 'string', 'exists:DOCTEUR,id_docteur'],
        'date' => ['required', 'date', 'after_or_equal:today'],
        'time' => ['required', 'date_format:H:i'],
        'reason' => ['nullable', 'string', 'max:150'],
    ]);
    $etablissementId = Auth::user()->id_etablissement;
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])->where('id_etablissement', $etablissementId)->exists(), 422);
    abort_unless(DB::table('DOCTEUR')->where('id_docteur', $validated['doctor_id'])->where('id_etablissement', $etablissementId)->exists(), 422);
    DB::table('RENDEZ_VOUS')->insert([
        'id_rendez_vous' => (string) Str::uuid(), 'id_patient' => $validated['patient_id'], 'id_docteur' => $validated['doctor_id'],
        'id_etablissement' => $etablissementId, 'date_rdv' => $validated['date'], 'heure_rdv' => $validated['time'],
        'motif' => $validated['reason'] ?? null, 'statut' => 'Planifié', 'created_at' => now(), 'updated_at' => now(),
    ]);
    return to_route('admin.dashboard', ['section' => 'rendez-vous'])->with('success', 'Le rendez-vous a été programmé.');
})->middleware('auth')->name('appointments.store');

Route::delete('/admin/rendez-vous/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    DB::table('RENDEZ_VOUS')->where('id_rendez_vous', $id)->where('id_etablissement', Auth::user()->id_etablissement)->delete();
    return to_route('admin.dashboard', ['section' => 'rendez-vous'])->with('success', 'Le rendez-vous a été supprimé.');
})->middleware('auth')->name('appointments.destroy');

Route::put('/admin/rendez-vous/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'], 'doctor_id' => ['required', 'string', 'exists:DOCTEUR,id_docteur'],
        'date' => ['required', 'date', 'after_or_equal:today'], 'time' => ['required', 'date_format:H:i'], 'reason' => ['nullable', 'string', 'max:150'],
    ]);
    $etablissementId = Auth::user()->id_etablissement;
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])->where('id_etablissement', $etablissementId)->exists(), 422);
    abort_unless(DB::table('DOCTEUR')->where('id_docteur', $validated['doctor_id'])->where('id_etablissement', $etablissementId)->exists(), 422);
    DB::table('RENDEZ_VOUS')->where('id_rendez_vous', $id)->where('id_etablissement', $etablissementId)->update([
        'id_patient' => $validated['patient_id'], 'id_docteur' => $validated['doctor_id'], 'date_rdv' => $validated['date'], 'heure_rdv' => $validated['time'],
        'motif' => $validated['reason'] ?? null, 'updated_at' => now(),
    ]);
    return to_route('admin.dashboard', ['section' => 'rendez-vous'])->with('success', 'Le rendez-vous a été modifié.');
})->middleware('auth')->name('appointments.update');

Route::post('/admin/services', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom_service' => ['required', 'string', 'max:100'], 'type_service' => ['nullable', 'string', 'max:100'],
        'telephone' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255'],
    ]);
    DB::table('SERVICE')->insert($validated + [
        'id_service' => (string) Str::uuid(), 'id_etablissement' => Auth::user()->id_etablissement,
    ]);
    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été créé.');
})->middleware('auth')->name('services.store');

Route::put('/admin/services/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom_service' => ['required', 'string', 'max:100'], 'type_service' => ['nullable', 'string', 'max:100'],
        'telephone' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255'],
    ]);
    DB::table('SERVICE')->where('id_service', $id)->where('id_etablissement', Auth::user()->id_etablissement)->update($validated);
    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été modifié.');
})->middleware('auth')->name('services.update');

Route::delete('/admin/services/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    DB::table('SERVICE')->where('id_service', $id)->where('id_etablissement', Auth::user()->id_etablissement)->delete();
    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été supprimé.');
})->middleware('auth')->name('services.destroy');

Route::put('/admin/medecins/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'], 'prenom' => ['required', 'string', 'max:100'],
        'specialite' => ['nullable', 'string', 'max:100'], 'telephone' => ['nullable', 'string', 'max:30'],
        'email' => ['nullable', 'email', 'max:255'],
    ]);
    $doctor = DB::table('DOCTEUR')->where('id_docteur', $id)->where('id_etablissement', Auth::user()->id_etablissement)->first();
    abort_unless($doctor, 404);
    DB::transaction(function () use ($doctor, $validated, $id): void {
        DB::table('DOCTEUR')->where('id_docteur', $id)->update($validated);
        if ($doctor->id_user) {
            DB::table('UTILISATEUR')->where('id_user', $doctor->id_user)->update([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'] ?? $doctor->email,
            ]);
        }
    });
    return to_route('admin.dashboard', ['section' => 'medecins'])->with('success', 'Le médecin a été modifié.');
})->middleware('auth')->name('doctors.update');

Route::patch('/admin/medecins/{id}/approve', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $doctor = DB::table('DOCTEUR')->where('id_docteur', $id)
        ->where('id_etablissement', Auth::user()->id_etablissement)->first();
    abort_unless($doctor, 404);

    DB::transaction(function () use ($doctor): void {
        $userId = $doctor->id_user;
        if (! $userId) {
            $userId = (string) Str::uuid();
            DB::table('UTILISATEUR')->insert([
                'id_user' => $userId, 'nom' => $doctor->nom, 'prenom' => $doctor->prenom,
                'email' => $doctor->email, 'mot_de_passe' => $doctor->mot_de_passe,
                'id_role' => 'role-doctor', 'id_etablissement' => $doctor->id_etablissement,
            ]);
        }
        DB::table('DOCTEUR')->where('id_docteur', $doctor->id_docteur)->update([
            'id_user' => $userId, 'est_approuve' => true,
        ]);
    });
    return to_route('admin.dashboard', ['section' => 'medecins'])->with('success', 'La demande du médecin a été approuvée.');
})->middleware('auth')->name('doctors.approve');

Route::delete('/admin/medecins/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    DB::table('DOCTEUR')->where('id_docteur', $id)->where('id_etablissement', Auth::user()->id_etablissement)->delete();
    return to_route('admin.dashboard', ['section' => 'medecins'])->with('success', 'Le médecin a été supprimé.');
})->middleware('auth')->name('doctors.destroy');

Route::get('/admin/medecins', function () {
    return to_route('admin.dashboard', ['section' => 'medecins']);
})->middleware('auth')->name('admin.medecins');