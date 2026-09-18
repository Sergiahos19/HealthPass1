<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

function generatePatientNpi(): string
{
    $prefix = 'NPI-';
    do {
        $npi = $prefix.strtoupper(Str::random(12));
    } while (DB::table('PATIENT')->where('npi', $npi)->exists());

    return $npi;
}

/**
 * The database keeps the historical establishment key for compatibility,
 * but HealthPass has one installation and therefore one shared data scope.
 */
function healthPassEstablishmentId(): string
{
    return (string) (DB::table('ETABLISSEMENT')->orderBy('id_etablissement')->value('id_etablissement') ?: 'etab-demo');
}

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route vers la page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/mot-de-passe-oublie', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/mot-de-passe-oublie', function (Request $request) {
    $validated = $request->validate(['email' => ['required', 'email']]);
    $email = mb_strtolower(trim($validated['email']));
    $user = DB::table('UTILISATEUR')->whereRaw('LOWER(email) = ?', [$email])->first();

    if ($user) {
        $plainToken = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($plainToken), 'created_at' => now()]
        );
        $resetUrl = route('password.reset', ['token' => $plainToken, 'email' => $email]);

        try {
            Mail::html(
                view('emails.password-reset', ['resetUrl' => $resetUrl])->render(),
                function ($message) use ($email): void {
                    $message->to($email)->subject('Réinitialisation de votre mot de passe HealthPass');
                }
            );
        } catch (\Throwable $exception) {
            report($exception);
            \Log::error('Password reset email delivery failed.', [
                'email' => $email,
                'exception' => $exception->getMessage(),
            ]);

            return to_route('password.request')->withErrors([
                'email' => 'Le lien n’a pas pu être envoyé. Vérifiez la configuration du service e-mail.',
            ])->withInput();
        }
    }

    return to_route('password.request')->with('success', 'Si cette adresse correspond à un compte, un lien de réinitialisation vient d’être envoyé.');
})->name('password.email');

Route::get('/reinitialiser-mot-de-passe/{token}', function (Request $request, string $token) {
    abort_unless($request->filled('email'), 404);
    return view('auth.reset-password', ['token' => $token, 'email' => $request->string('email')->value()]);
})->name('password.reset');

Route::post('/reinitialiser-mot-de-passe', function (Request $request) {
    $validated = $request->validate([
        'token' => ['required', 'string'],
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
    $reset = DB::table('password_reset_tokens')->where('email', mb_strtolower($validated['email']))->first();
    abort_unless($reset && now()->diffInMinutes($reset->created_at) <= 60 && Hash::check($validated['token'], $reset->token), 422, 'Le lien de réinitialisation est invalide ou expiré.');
    DB::table('UTILISATEUR')->whereRaw('LOWER(email) = ?', [mb_strtolower($validated['email'])])->update(['mot_de_passe' => Hash::make($validated['password'])]);
    DB::table('password_reset_tokens')->where('email', mb_strtolower($validated['email']))->delete();

    return to_route('login')->with('success', 'Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.');
})->name('password.update');

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
                    'nom' => 'Exaucé',
                    'prenom' => 'Sergio',
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
                'nom' => 'Exaucé',
                'prenom' => 'Sergio',
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

    if (! $user || (Schema::hasColumn('UTILISATEUR', 'est_actif') && ! (bool) $user->est_actif) || ! Hash::check($credentials['password'], $user->mot_de_passe)) {
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
    if ($authenticatedUser->isService()) {
        $service = Schema::hasTable('SERVICE') && filled($user->id_service)
            ? DB::table('SERVICE')->where('id_service', $user->id_service)
                ->first()
            : null;

        $serviceApproved = ! $service
            || ! Schema::hasColumn('SERVICE', 'est_approuve')
            || (bool) ($service->est_approuve ?? true);

        if (! $serviceApproved) {
            Auth::logout();
            return back()->withErrors(['email' => 'Votre demande de service n’a pas encore été approuvée.'])
                ->onlyInput('email');
        }
    }
    if (! in_array($authenticatedUser->id_role, ['role-admin', 'role-service', 'role-doctor', 'role-cashier', 'role-patient'], true)) {
        Auth::logout();
        return back()->withErrors(['email' => 'Les identifiants sont incorrects.'])->onlyInput('email');
    }

    Auth::login($authenticatedUser, $request->boolean('remember'));
    $request->session()->regenerate();

    if ($authenticatedUser->mustChangePassword()) {
        return to_route('password.first-change');
    }

    if ($authenticatedUser->isDoctor()) {
        return to_route('doctor.dashboard');
    }
    if ($authenticatedUser->isService()) {
        return to_route('service.dashboard');
    }
    if ($authenticatedUser->isCashier()) {
        return to_route('billing.dashboard');
    }
    if ($authenticatedUser->isPatient()) {
        return to_route('patient.dashboard');
    }

    return to_route('admin.dashboard');
})->name('login.store');


Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('home');
})->middleware('auth')->name('logout');

Route::get('/mot-de-passe/premiere-connexion', function () {
    abort_unless(Auth::check() && Auth::user()->mustChangePassword(), 404);

    return view('auth.first-password-change');
})->middleware('auth')->name('password.first-change');

Route::post('/mot-de-passe/premiere-connexion', function (Request $request) {
    $user = Auth::user();
    abort_unless($user?->mustChangePassword(), 404);

    $validated = $request->validate([
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    DB::table('UTILISATEUR')->where('id_user', $user->id_user)->update([
        'mot_de_passe' => Hash::make($validated['password']),
        'doit_changer_mot_de_passe' => false,
    ]);

    $user->mot_de_passe = Hash::make($validated['password']);
    $user->doit_changer_mot_de_passe = false;
    Auth::setUser($user);

    $destination = $user->isDoctor() ? 'doctor.dashboard'
        : ($user->isService() ? 'service.dashboard'
        : ($user->isCashier() ? 'billing.dashboard'
        : ($user->isPatient() ? 'patient.dashboard' : 'admin.dashboard')));

    return to_route($destination)->with('success', 'Votre mot de passe a été modifié. Vous pouvez maintenant accéder à votre espace.');
})->middleware('auth')->name('password.first-change.store');

/*
|--------------------------------------------------------------------------
| Espace médecin
|--------------------------------------------------------------------------
*/
$doctorForAuthenticatedUser = static function () {
    abort_unless(Auth::user()?->isDoctor(), 403);

    $doctorQuery = DB::table('DOCTEUR')
        ->leftJoin('ETABLISSEMENT', 'ETABLISSEMENT.id_etablissement', '=', 'DOCTEUR.id_etablissement');
    $doctorQuery->select('DOCTEUR.*', 'ETABLISSEMENT.nom_etablissement');
    $doctor = Schema::hasColumn('DOCTEUR', 'id_user')
        ? $doctorQuery->where('id_user', Auth::user()->id_user)->first()
        : $doctorQuery->whereRaw('LOWER(email) = ?', [mb_strtolower(Auth::user()->email)])->first();

    abort_unless($doctor, 404);
    if (Schema::hasColumn('DOCTEUR', 'est_approuve')) {
        abort_unless((bool) $doctor->est_approuve, 403);
    }

    return $doctor;
};

Route::get('/medecin/dashboard', function () use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    $etablissementId = healthPassEstablishmentId();
    $section = request()->string('section', 'home')->value();
    $allowedSections = ['home', 'patients', 'consultations', 'analyses', 'settings'];
    $section = in_array($section, $allowedSections, true) ? $section : 'home';
    $patientsQuery = DB::table('PATIENT');
    $patientsTotal = (clone $patientsQuery)->count();
    $patientsHommes = (clone $patientsQuery)->where('sexe', 'M')->count();
    $patientsFemmes = (clone $patientsQuery)->where('sexe', 'F')->count();
    $patientsNouveaux = Schema::hasColumn('PATIENT', 'created_at')
        ? (clone $patientsQuery)->whereDate('created_at', today())->count() : 0;
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
    if (in_array($sexe, ['M', 'F', 'X'], true)) $patientsQuery->where('sexe', $sexe);
    if (in_array($groupeSanguin, ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'], true)
        && Schema::hasColumn('PATIENT', 'groupe_sanguin')) $patientsQuery->where('groupe_sanguin', $groupeSanguin);
    $patients = $patientsQuery->orderBy('nom')->orderBy('prenom')->get();
    $patientFocus = null;
    $consultationsPatient = collect();
    $analysesPatient = collect();
    $prescriptionsPatient = collect();
    $recordType = request()->string('record_type')->value();
    $recordId = request()->string('record_id')->value();
    $recordDetail = null;
    $selectedPatientId = request()->string('patient')->value();
    if ($section === 'consultations' && $selectedPatientId === '' && Schema::hasTable('RENDEZ_VOUS')) {
        $selectedPatientId = (string) DB::table('RENDEZ_VOUS')->where('id_docteur', $doctor->id_docteur)
            ->whereDate('date_rdv', today())->orderBy('heure_rdv')->value('id_patient');
    }
    if ($selectedPatientId !== '') {
        $patientFocus = DB::table('PATIENT')->where('id_patient', $selectedPatientId)
            ->first();
        abort_unless($patientFocus, 404);
        if (Schema::hasTable('CONSULTATION')) {
            $consultationsPatient = DB::table('CONSULTATION')->where('id_patient', $selectedPatientId)
                ->where('id_docteur', $doctor->id_docteur)->latest('date_consultation')->get();
        }
        if (Schema::hasTable('DEMANDE_ANALYSE') && Schema::hasTable('FORMAT')) {
            $analysesPatient = DB::table('DEMANDE_ANALYSE')
                ->join('FORMAT', 'FORMAT.id_format', '=', 'DEMANDE_ANALYSE.id_format')
                ->leftJoin('SERVICE', 'SERVICE.id_service', '=', 'DEMANDE_ANALYSE.id_service')
                ->where('DEMANDE_ANALYSE.id_patient', $selectedPatientId)
                ->where('DEMANDE_ANALYSE.id_docteur', $doctor->id_docteur)
                ->select(
                    'DEMANDE_ANALYSE.*',
                    'DEMANDE_ANALYSE.demande_at as date_analyse',
                    DB::raw('COALESCE(FORMAT.type_examen, FORMAT.libelle_format) as type_analyse'),
                    'SERVICE.nom_service'
                )
                ->latest('DEMANDE_ANALYSE.demande_at')->get();
        } elseif (Schema::hasTable('ANALYSE')) {
            $analysesPatient = DB::table('ANALYSE')->leftJoin('SERVICE', 'SERVICE.id_service', '=', 'ANALYSE.id_service')
                ->where('ANALYSE.id_patient', $selectedPatientId)->where('ANALYSE.id_docteur', $doctor->id_docteur)
                ->select('ANALYSE.*', 'SERVICE.nom_service')->latest('date_analyse')->get();
        }
        if (Schema::hasTable('PRESCRIPTION')) {
            $prescriptionsPatient = DB::table('PRESCRIPTION')->where('id_patient', $selectedPatientId)
                ->where('id_docteur', $doctor->id_docteur)->latest('date_prescription')->get();
        }
        if ($recordId !== '' && in_array($recordType, ['consultations', 'analyses', 'prescriptions'], true)) {
            $recordDetail = match ($recordType) {
                'consultations' => Schema::hasTable('CONSULTATION')
                    ? DB::table('CONSULTATION')->join('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'CONSULTATION.id_docteur')
                        ->where('CONSULTATION.id_consultation', $recordId)->where('CONSULTATION.id_patient', $selectedPatientId)
                        ->where('CONSULTATION.id_docteur', $doctor->id_docteur)
                        ->select('CONSULTATION.*', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->first() : null,
                'analyses' => $analysesPatient->firstWhere('id_demande', $recordId) ?: $analysesPatient->firstWhere('id_analyse', $recordId),
                'prescriptions' => $prescriptionsPatient->firstWhere('id_prescription', $recordId),
            };
            abort_unless($recordDetail, 404);
        }
    }
    $todayAppointments = Schema::hasTable('RENDEZ_VOUS')
        ? DB::table('RENDEZ_VOUS')->join('PATIENT', 'PATIENT.id_patient', '=', 'RENDEZ_VOUS.id_patient')
            ->where('RENDEZ_VOUS.id_docteur', $doctor->id_docteur)
            ->whereDate('RENDEZ_VOUS.date_rdv', today())->select('RENDEZ_VOUS.*', 'PATIENT.nom', 'PATIENT.prenom', 'PATIENT.sexe', 'PATIENT.groupe_sanguin')->orderBy('heure_rdv')->get()
        : collect();
    $todayConsultations = Schema::hasTable('CONSULTATION')
        ? DB::table('CONSULTATION')->where('id_docteur', $doctor->id_docteur)->whereDate('date_consultation', today())->count()
        : 0;
    $todayAnalyses = Schema::hasTable('DEMANDE_ANALYSE')
        ? DB::table('DEMANDE_ANALYSE')->where('id_docteur', $doctor->id_docteur)->whereDate('demande_at', today())->count()
        : (Schema::hasTable('ANALYSE')
            ? DB::table('ANALYSE')->where('id_docteur', $doctor->id_docteur)->whereDate('date_analyse', today())->count()
            : 0);
    $services = Schema::hasTable('SERVICE') ? DB::table('SERVICE')->orderBy('nom_service')->get() : collect();
    $recentConsultations = Schema::hasTable('CONSULTATION')
        ? DB::table('CONSULTATION')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'CONSULTATION.id_patient')
            ->where('CONSULTATION.id_docteur', $doctor->id_docteur)
            ->select('CONSULTATION.*', 'PATIENT.nom', 'PATIENT.prenom')
            ->latest('CONSULTATION.date_consultation')->latest('CONSULTATION.created_at')->limit(5)->get()
        : collect();
    return view('admin.docteur.dashboard', compact('doctor', 'section', 'patients', 'patientsTotal', 'patientsHommes', 'patientsFemmes', 'patientsNouveaux', 'search', 'sexe', 'groupeSanguin', 'datePeriod', 'dateFrom', 'dateTo', 'patientFocus', 'consultationsPatient', 'analysesPatient', 'prescriptionsPatient', 'recordType', 'recordDetail', 'todayAppointments', 'todayConsultations', 'todayAnalyses', 'services', 'recentConsultations'));
})->middleware('auth')->name('doctor.dashboard');

foreach (['patients', 'consultations', 'analyses', 'settings'] as $doctorSection) {
    Route::get('/medecin/'.$doctorSection, fn () => to_route('doctor.dashboard', ['section' => $doctorSection, 'patient' => request('patient')]))
        ->middleware('auth')->name('doctor.'.$doctorSection);
}
Route::get('/medecin/patients/{id}', fn (string $id) => to_route('doctor.dashboard', ['section' => 'patients', 'patient' => $id]))->middleware('auth')->name('doctor.patients.show');
Route::get('/medecin/patients/{id}/edit', fn (string $id) => to_route('doctor.dashboard', ['section' => 'patients', 'patient' => $id, 'edit' => 1]))->middleware('auth')->name('doctor.patients.edit');
Route::post('/medecin/consultations', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    abort_unless(Schema::hasTable('CONSULTATION'), 503);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'motif' => ['nullable', 'string', 'max:1000'], 'symptomes' => ['nullable', 'string', 'max:5000'],
        'diagnostic' => ['nullable', 'string', 'max:5000'], 'traitement' => ['nullable', 'string', 'max:5000'],
        'observation_medicale' => ['nullable', 'string', 'max:5000'],
    ]);
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])->exists(), 404);
    $data = $validated + ['id_consultation' => (string) Str::uuid(), 'date_consultation' => today(), 'heure' => now()->format('H:i:s'), 'id_patient' => $validated['patient_id'], 'id_docteur' => $doctor->id_docteur];
    unset($data['patient_id']);
    $data['id_patient'] = $validated['patient_id'];
    if (Schema::hasColumn('CONSULTATION', 'id_etablissement')) $data['id_etablissement'] = healthPassEstablishmentId();
    DB::table('CONSULTATION')->insert($data);
    return to_route('doctor.consultations')->with('success', 'La consultation a été enregistrée.');
})->middleware('auth')->name('doctor.consultations.store');
Route::post('/medecin/analyses', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    abort_unless(Schema::hasTable('DEMANDE_ANALYSE') && Schema::hasTable('FORMAT'), 503);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'service_id' => ['required', 'string', 'exists:SERVICE,id_service'],
        'type_analyse' => ['required', 'string', 'max:150'],
        'priorite' => ['required', 'in:Normale,Urgente'],
        'prescription' => ['nullable', 'string', 'max:10000'],
        'observation' => ['nullable', 'string', 'max:10000'],
    ]);
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])
        ->exists(), 404);
    abort_unless(DB::table('SERVICE')->where('id_service', $validated['service_id'])
        ->exists(), 404);

    $format = DB::table('FORMAT')->where('id_service', $validated['service_id'])
        ->where('type_examen', $validated['type_analyse'])->first();
    if (! $format) {
        $formatId = (string) Str::uuid();
        DB::table('FORMAT')->insert([
            'id_format' => $formatId,
            'libelle_format' => $validated['type_analyse'],
            'type_examen' => $validated['type_analyse'],
            'id_service' => $validated['service_id'],
        ]);
    } else {
        $formatId = $format->id_format;
    }
    DB::table('DEMANDE_ANALYSE')->insert([
        'id_demande' => (string) Str::uuid(),
        'id_patient' => $validated['patient_id'],
        'id_docteur' => $doctor->id_docteur,
        'id_service' => $validated['service_id'],
        'id_format' => $formatId,
        'priorite' => $validated['priorite'],
        'statut' => 'En attente',
        'demande_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ] + array_intersect_key($validated, array_flip(['prescription', 'observation'])));
    return to_route('doctor.analyses', ['patient' => $validated['patient_id']])
        ->with('success', 'La demande d’analyse a été enregistrée.');
})->middleware('auth')->name('doctor.analyses.store');
Route::post('/medecin/prescriptions', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    abort_unless(Schema::hasTable('PRESCRIPTION'), 503);
    $validated = $request->validate(['patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'], 'medicaments' => ['required', 'array', 'min:1'], 'medicaments.*.medicament' => ['required', 'string', 'max:150'], 'medicaments.*.dosage' => ['nullable', 'string', 'max:100'], 'medicaments.*.duree_jours' => ['nullable', 'integer', 'min:1'], 'medicaments.*.frequence' => ['nullable', 'string', 'max:100'], 'medicaments.*.quantite' => ['nullable', 'integer', 'min:1']]);
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])->exists(), 404);
    foreach ($validated['medicaments'] as $medicament) DB::table('PRESCRIPTION')->insert($medicament + ['id_prescription' => (string) Str::uuid(), 'id_patient' => $validated['patient_id'], 'id_docteur' => $doctor->id_docteur, 'id_etablissement' => healthPassEstablishmentId(), 'date_prescription' => today(), 'created_at' => now(), 'updated_at' => now()]);
    return to_route('doctor.consultations')->with('success', 'La prescription a été enregistrée.');
})->middleware('auth')->name('doctor.prescriptions.store');
Route::put('/medecin/patients/{id}', fn (string $id) => to_route('doctor.dashboard', ['section' => 'patients', 'patient' => $id]))->middleware('auth')->name('doctor.patients.update');
Route::delete('/medecin/patients/{id}', fn () => to_route('doctor.patients'))->middleware('auth')->name('doctor.patients.destroy');

Route::put('/medecin/parametres', function (Request $request) use ($doctorForAuthenticatedUser) {
    $doctor = $doctorForAuthenticatedUser();
    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'], 'prenom' => ['required', 'string', 'max:100'],
        'specialite' => ['nullable', 'string', 'max:100'], 'telephone' => ['nullable', 'string', 'max:30'],
        'email' => ['required', 'email', 'max:255'],
    ]);
    DB::table('DOCTEUR')->where('id_docteur', $doctor->id_docteur)->update($validated);
    if (Schema::hasColumn('DOCTEUR', 'id_user') && $doctor->id_user) {
        DB::table('UTILISATEUR')->where('id_user', $doctor->id_user)->update([
            'nom' => $validated['nom'], 'prenom' => $validated['prenom'], 'email' => $validated['email'],
        ]);
    }
    return to_route('doctor.settings')->with('success', 'Vos paramètres ont été enregistrés.');
})->middleware('auth')->name('doctor.settings.update');

Route::get('/service/dashboard', function () {
    abort_unless(Auth::user()?->isService(), 403);
    abort_unless(Schema::hasTable('SERVICE'), 503);
    $service = DB::table('SERVICE')->where('id_service', Auth::user()->id_service)->first();
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

    if (Schema::hasTable('DEMANDE_ANALYSE')) {
        $demandes = DB::table('DEMANDE_ANALYSE')->where('id_service', $service->id_service)->count();
        $demandesRecentes = DB::table('DEMANDE_ANALYSE')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'DEMANDE_ANALYSE.id_patient')
            ->join('FORMAT', 'FORMAT.id_format', '=', 'DEMANDE_ANALYSE.id_format')
            ->leftJoin('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'DEMANDE_ANALYSE.id_docteur')
            ->where('DEMANDE_ANALYSE.id_service', $service->id_service)->latest('DEMANDE_ANALYSE.demande_at')->limit(5)
            ->select('DEMANDE_ANALYSE.*', 'FORMAT.libelle_format', 'PATIENT.nom', 'PATIENT.prenom', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->get();
        $urgentes = DB::table('DEMANDE_ANALYSE')->where('id_service', $service->id_service)->whereIn('priorite', ['Urgente', 'STAT'])->whereNotIn('statut', ['Terminé'])->count();
        $traitees = DB::table('DEMANDE_ANALYSE')->where('id_service', $service->id_service)->where('statut', 'Terminé')->whereDate('traitee_at', today())->count();
    }

    $section = request()->string('section')->value();
    $patients = $section === 'analyses' && Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->orderBy('nom')->orderBy('prenom')->get()
        : collect();
    $demandesAnalyse = $section === 'analyses' && Schema::hasTable('DEMANDE_ANALYSE')
        ? DB::table('DEMANDE_ANALYSE')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'DEMANDE_ANALYSE.id_patient')
            ->join('FORMAT', 'FORMAT.id_format', '=', 'DEMANDE_ANALYSE.id_format')
            ->leftJoin('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'DEMANDE_ANALYSE.id_docteur')
            ->where('DEMANDE_ANALYSE.id_service', $service->id_service)->latest('DEMANDE_ANALYSE.demande_at')->limit(20)
            ->select('DEMANDE_ANALYSE.*', 'PATIENT.nom', 'PATIENT.prenom', 'PATIENT.npi', 'FORMAT.libelle_format', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->get()
        : collect();
    $demandesPourSaisie = $section === 'analyses' && Schema::hasTable('DEMANDE_ANALYSE')
        ? DB::table('DEMANDE_ANALYSE')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'DEMANDE_ANALYSE.id_patient')
            ->join('FORMAT', 'FORMAT.id_format', '=', 'DEMANDE_ANALYSE.id_format')
            ->leftJoin('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'DEMANDE_ANALYSE.id_docteur')
            ->where('DEMANDE_ANALYSE.id_service', $service->id_service)
            ->whereNotIn('DEMANDE_ANALYSE.statut', ['Terminé', 'Terminee'])
            ->orderBy('PATIENT.nom')->orderBy('PATIENT.prenom')
            ->select(
                'DEMANDE_ANALYSE.*',
                'PATIENT.nom',
                'PATIENT.prenom',
                'FORMAT.libelle_format',
                'DOCTEUR.nom as docteur_nom',
                'DOCTEUR.prenom as docteur_prenom'
            )->get()
        : collect();
    $demandeSelectionnee = request()->filled('demande') && Schema::hasTable('DEMANDE_ANALYSE')
        ? DB::table('DEMANDE_ANALYSE')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'DEMANDE_ANALYSE.id_patient')
            ->join('FORMAT', 'FORMAT.id_format', '=', 'DEMANDE_ANALYSE.id_format')
            ->leftJoin('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'DEMANDE_ANALYSE.id_docteur')
            ->where('DEMANDE_ANALYSE.id_service', $service->id_service)
            ->where('DEMANDE_ANALYSE.id_demande', request()->string('demande')->value())
            ->select('DEMANDE_ANALYSE.*', 'PATIENT.nom', 'PATIENT.prenom', 'PATIENT.npi', 'FORMAT.libelle_format', 'FORMAT.type_examen', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->first()
        : null;
        $serviceSettings = $section === 'parametres' && $service ? $service : null;

    return view('admin.services.dashboard', compact('service', 'demandes', 'demandesRecentes', 'urgentes', 'traitees', 'formats', 'formatsTotal', 'section', 'patients', 'demandesAnalyse', 'demandesPourSaisie', 'demandeSelectionnee', 'serviceSettings'));
})->middleware('auth')->name('service.dashboard');

Route::get('/service/analyses', function () {
    return to_route('service.dashboard', ['section' => 'analyses']);
})->middleware('auth')->name('service.analyses');

Route::get('/service/parametres', function () {
    abort_unless(Auth::user()?->isService(), 403);
    $service = DB::table('SERVICE')->where('id_service', Auth::user()->id_service)->first();
    abort_unless($service, 404);
    return to_route('service.dashboard', ['section' => 'parametres']);
})->middleware('auth')->name('service.settings');

Route::put('/service/parametres', function (Request $request) {
    abort_unless(Auth::user()?->isService(), 403);
    $validated = $request->validate([
        'nom_service' => ['required', 'string', 'max:100'], 'type_service' => ['nullable', 'string', 'max:100'],
        'telephone' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255'],
        'batiment' => ['nullable', 'string', 'max:100'], 'etage' => ['nullable', 'string', 'max:50'],
        'email_connexion' => ['required', 'email', 'max:255', 'unique:UTILISATEUR,email,'.Auth::user()->id_user.',id_user'],
        'current_password' => ['required', 'string'], 'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);
    abort_unless(Hash::check($validated['current_password'], Auth::user()->mot_de_passe), 422, 'Mot de passe actuel incorrect.');
    DB::table('SERVICE')->where('id_service', Auth::user()->id_service)->update(collect($validated)->only(['nom_service', 'type_service', 'telephone', 'email', 'batiment', 'etage'])->all());
    DB::table('UTILISATEUR')->where('id_user', Auth::user()->id_user)->update(array_filter([
        'email' => $validated['email_connexion'],
        'mot_de_passe' => filled($validated['new_password'] ?? null) ? Hash::make($validated['new_password']) : null,
    ]));
    return to_route('service.dashboard', ['section' => 'parametres'])->with('success', 'Les paramètres du service ont été enregistrés.');
})->middleware('auth')->name('service.settings.update');

Route::put('/service/analyses/{id}/resultat', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isService(), 403);
    $service = DB::table('SERVICE')->where('id_service', Auth::user()->id_service)->first();
    abort_unless($service, 404);
    $validated = $request->validate([
        'resultat' => ['required', 'string', 'max:10000'],
    ]);
    $updated = DB::table('DEMANDE_ANALYSE')->where('id_demande', $id)->where('id_service', $service->id_service)->whereNotIn('statut', ['Terminé', 'Terminee'])->update([
        'resultat' => $validated['resultat'], 'statut' => 'Terminé', 'traitee_at' => now(), 'updated_at' => now(),
    ]);
    abort_unless($updated, 404);
    return to_route('service.dashboard', ['section' => 'analyses'])->with('success', 'Le résultat a été enregistré.');
})->middleware('auth')->name('service.analyses.resultat');

Route::get('/facturation', function () {
    abort_unless(Auth::user()?->isCashier() || Auth::user()?->isAdministrator(), 403);
    abort_unless(Schema::hasTable('FACTURE'), 503);

    $factures = DB::table('FACTURE')
        ->join('PATIENT', 'PATIENT.id_patient', '=', 'FACTURE.id_patient')
        ->leftJoin('UTILISATEUR', 'UTILISATEUR.id_user', '=', 'FACTURE.id_caissier')
        ->select('FACTURE.*', 'PATIENT.nom', 'PATIENT.prenom', 'PATIENT.npi', 'UTILISATEUR.nom as caissier_nom', 'UTILISATEUR.prenom as caissier_prenom')
        ->latest('FACTURE.date_facture')
        ->latest('FACTURE.created_at')
        ->get();
    $patients = DB::table('PATIENT')->orderBy('nom')->orderBy('prenom')->get();

    return view('billing.dashboard', compact('factures', 'patients'));
})->middleware('auth')->name('billing.dashboard');

Route::post('/facturation', function (Request $request) {
    abort_unless(Auth::user()?->isCashier() || Auth::user()?->isAdministrator(), 403);
    abort_unless(Schema::hasTable('FACTURE'), 503);

    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'montant' => ['required', 'numeric', 'min:0'],
        'mode_paiement' => ['nullable', 'string', 'max:40'],
        'description' => ['nullable', 'string', 'max:1000'],
    ]);

    DB::table('FACTURE')->insert([
        'id_facture' => (string) Str::uuid(),
        'numero_facture' => 'HP-'.now()->format('YmdHis').'-'.strtoupper(Str::random(4)),
        'id_patient' => $validated['patient_id'],
        'id_caissier' => Auth::user()->id_user,
        'montant' => $validated['montant'],
        'mode_paiement' => $validated['mode_paiement'] ?? null,
        'description' => $validated['description'] ?? null,
        'date_facture' => today(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return to_route('billing.dashboard')->with('success', 'La facture a été enregistrée.');
})->middleware('auth')->name('billing.store');

Route::post('/admin/utilisateurs', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);

    $validated = $request->validate([
        'role' => ['required', Rule::in(['role-doctor', 'role-service'])],
        'nom' => ['required', 'string', 'max:100'],
        'prenom' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255', 'unique:UTILISATEUR,email'],
        'specialite' => ['required', 'string', 'max:150'],
        'telephone' => ['nullable', 'string', 'max:30'],
    ]);

    $temporaryPassword = 'HP-'.Str::upper(Str::random(10));
    $userId = (string) Str::uuid();
    $establishmentId = healthPassEstablishmentId();

    DB::transaction(function () use ($validated, $temporaryPassword, $userId, $establishmentId): void {
        $password = Hash::make($temporaryPassword);
        DB::table('UTILISATEUR')->insert([
            'id_user' => $userId,
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'mot_de_passe' => $password,
            'id_role' => $validated['role'],
            'id_etablissement' => $establishmentId,
            'doit_changer_mot_de_passe' => true,
        ]);

        if ($validated['role'] === 'role-doctor') {
            DB::table('DOCTEUR')->insert([
                'id_docteur' => (string) Str::uuid(),
                'id_user' => $userId,
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'specialite' => $validated['specialite'],
                'telephone' => $validated['telephone'] ?? null,
                'email' => $validated['email'],
                'mot_de_passe' => $password,
                'id_etablissement' => $establishmentId,
                'est_approuve' => true,
            ]);
        } else {
            $serviceId = (string) Str::uuid();
            DB::table('SERVICE')->insert([
                'id_service' => $serviceId,
                'nom_service' => $validated['specialite'],
                'type_service' => $validated['specialite'],
                'telephone' => $validated['telephone'] ?? null,
                'email' => $validated['email'],
                'id_etablissement' => $establishmentId,
                'chef_prenom' => $validated['prenom'],
                'chef_nom' => $validated['nom'],
                'mot_de_passe' => $password,
            ]);
            DB::table('UTILISATEUR')->where('id_user', $userId)->update(['id_service' => $serviceId]);
        }
    });

    $roleLabel = $validated['role'] === 'role-doctor' ? 'médecin' : 'service';
    $mailError = false;
    try {
        Mail::html(
            view('emails.user-account-created', [
                'name' => trim($validated['prenom'].' '.$validated['nom']),
                'roleLabel' => $roleLabel,
                'email' => $validated['email'],
                'temporaryPassword' => $temporaryPassword,
                'loginUrl' => route('login'),
            ])->render(),
            function ($message) use ($validated): void {
                $message->to($validated['email'])
                    ->subject('Bienvenue sur HealthPass — vos identifiants de connexion');
            }
        );
    } catch (\Throwable $exception) {
        report($exception);
        $mailError = true;
    }

    $message = $mailError
        ? 'Le compte a été créé, mais l’e-mail n’a pas pu être envoyé. Communiquez temporairement les identifiants à l’utilisateur.'
        : 'Le compte a été créé et les identifiants ont été envoyés par e-mail.';

    return to_route('admin.dashboard', ['section' => 'utilisateurs'])->with($mailError ? 'warning' : 'success', $message);
})->middleware('auth')->name('admin.users.store');

Route::put('/admin/utilisateurs/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'],
        'prenom' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255', Rule::unique('UTILISATEUR', 'email')->ignore($id, 'id_user')],
        'specialite' => ['required', 'string', 'max:150'],
        'telephone' => ['nullable', 'string', 'max:30'],
    ]);
    $existing = DB::table('UTILISATEUR')->where('id_user', $id)->first();
    abort_unless($existing && $existing->id_role !== 'role-admin', 404);

    DB::transaction(function () use ($validated, $id, $existing): void {
        DB::table('UTILISATEUR')->where('id_user', $id)->update([
            'nom' => $validated['nom'], 'prenom' => $validated['prenom'], 'email' => $validated['email'],
        ]);
        if ($existing->id_role === 'role-doctor') {
            DB::table('DOCTEUR')->where('id_user', $id)->update([
                'nom' => $validated['nom'], 'prenom' => $validated['prenom'], 'email' => $validated['email'],
                'specialite' => $validated['specialite'], 'telephone' => $validated['telephone'] ?? null,
            ]);
        } else {
            $serviceId = DB::table('UTILISATEUR')->where('id_user', $id)->value('id_service');
            if ($serviceId) {
                DB::table('SERVICE')->where('id_service', $serviceId)->update([
                    'nom_service' => $validated['specialite'], 'type_service' => $validated['specialite'],
                    'chef_nom' => $validated['nom'], 'chef_prenom' => $validated['prenom'],
                    'email' => $validated['email'], 'telephone' => $validated['telephone'] ?? null,
                ]);
            }
        }
    });
    return to_route('admin.dashboard', ['section' => 'utilisateurs'])->with('success', 'Les informations de l’utilisateur ont été modifiées.');
})->middleware('auth')->name('admin.users.update');

Route::patch('/admin/utilisateurs/{id}/statut', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $user = DB::table('UTILISATEUR')->where('id_user', $id)->first();
    abort_unless($user && $user->id_role !== 'role-admin', 404);
    $active = ! (bool) ($user->est_actif ?? true);
    DB::table('UTILISATEUR')->where('id_user', $id)->update(['est_actif' => $active]);
    return to_route('admin.dashboard', ['section' => 'utilisateurs'])->with('success', $active ? 'Le compte a été activé.' : 'Le compte a été désactivé.');
})->middleware('auth')->name('admin.users.toggle');

Route::delete('/admin/utilisateurs/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $user = DB::table('UTILISATEUR')->where('id_user', $id)->first();
    abort_unless($user && $user->id_role !== 'role-admin', 404);
    DB::transaction(function () use ($id, $user): void {
        DB::table('DOCTEUR')->where('id_user', $id)->delete();
        if (! empty($user->id_service)) {
            DB::table('SERVICE')->where('id_service', $user->id_service)->delete();
        }
        DB::table('UTILISATEUR')->where('id_user', $id)->delete();
    });
    return to_route('admin.dashboard', ['section' => 'utilisateurs'])->with('success', 'L’utilisateur a été supprimé définitivement.');
})->middleware('auth')->name('admin.users.destroy');

Route::get('/patient/dashboard', function () {
    abort_unless(Auth::user()?->isPatient(), 403);
    $patient = Schema::hasColumn('PATIENT', 'id_user')
        ? DB::table('PATIENT')->where('id_user', Auth::user()->id_user)->first()
        : null;
    abort_unless($patient, 404);

    $consultations = Schema::hasTable('CONSULTATION')
        ? DB::table('CONSULTATION')->where('id_patient', $patient->id_patient)->latest('date_consultation')->get()
        : collect();
    $prescriptions = Schema::hasTable('PRESCRIPTION')
        ? DB::table('PRESCRIPTION')->where('id_patient', $patient->id_patient)->latest('date_prescription')->get()
        : collect();
    $factures = Schema::hasTable('FACTURE')
        ? DB::table('FACTURE')->where('id_patient', $patient->id_patient)->latest('date_facture')->get()
        : collect();

    return view('patient.dashboard', compact('patient', 'consultations', 'prescriptions', 'factures'));
})->middleware('auth')->name('patient.dashboard');

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
        'taille' => ['nullable', 'numeric', 'decimal:0,2', 'min:0.5', 'max:2.5'],
        'poids' => ['nullable', 'numeric', 'decimal:0,2', 'min:1', 'max:500'],
        'groupe_sanguin' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
        'contact_urgence_nom' => ['required', 'string', 'max:150'],
        'contact_urgence_lien' => ['required', 'string', 'max:80'],
        'contact_urgence_telephone' => ['required', 'string', 'max:30'],
        'contact_urgence_email' => ['nullable', 'email', 'max:255'],
        'contact_urgence_adresse' => ['nullable', 'string', 'max:500'],
        'biometric_data' => ['nullable', 'string'],
    ]);

    $validated['id_patient'] = (string) Str::uuid();
    $validated['id_etablissement'] = healthPassEstablishmentId();
    $validated['npi'] = generatePatientNpi();
    $validated['empreinte_digitale'] = $validated['biometric_data'] ?? null;
    unset($validated['biometric_data']);

    DB::table('PATIENT')->insert($validated);

    return to_route('admin.dashboard', ['section' => 'patients'])
        ->with('success', 'Le patient a été enregistré avec succès.');
})->middleware('auth')->name('patients.store');
Route::delete('/admin/patients/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $deleted = DB::table('PATIENT')->where('id_patient', $id)->delete();
    abort_unless($deleted, 404);
    return to_route('admin.dashboard', ['section' => 'patients'])->with('success', 'Le patient a été supprimé.');
})->middleware('auth')->name('admin.patients.destroy');
Route::put('/admin/patients/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate(['nom' => ['required', 'string', 'max:100'], 'prenom' => ['required', 'string', 'max:100'], 'sexe' => ['nullable', 'in:M,F,X'], 'telephone' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255']]);
    $updated = DB::table('PATIENT')->where('id_patient', $id)->update($validated);
    abort_unless($updated, 404);
    return to_route('admin.dashboard', ['section' => 'patients'])->with('success', 'Le dossier patient a été modifié.');
})->middleware('auth')->name('admin.patients.update');

// Route Tableau de bord Administrateur
Route::get('/admin/dashboard', function () {
    abort_unless(Auth::user()?->isAdministrator(), 403);

    $user = Auth::user();
    $isSuperAdmin = false;
    $etablissement = DB::table('ETABLISSEMENT')->first();
    $periode = request()->string('periode', 'today')->value();
    $dateFiltre = request()->input('date');
    if ($periode === 'date') {
        request()->validate(['date' => ['required', 'date', 'after_or_equal:today']]);
        $dateDebut = \Illuminate\Support\Carbon::parse($dateFiltre)->toDateString();
        $dateFin = $dateDebut;
    } else {
        $dateDebut = today()->toDateString();
        $dateFin = $periode === 'week' ? today()->addDays(6)->toDateString() : $dateDebut;
    }
    $rendezVous = Schema::hasTable('RENDEZ_VOUS')
        ? DB::table('RENDEZ_VOUS')
            ->join('PATIENT', 'PATIENT.id_patient', '=', 'RENDEZ_VOUS.id_patient')
            ->join('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'RENDEZ_VOUS.id_docteur')
            ->whereBetween('RENDEZ_VOUS.date_rdv', [$dateDebut, $dateFin])
            ->orderBy('date_rdv')->orderBy('heure_rdv')
            ->select('RENDEZ_VOUS.*', 'PATIENT.nom', 'PATIENT.prenom', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->get()
        : collect();
    $patientsRecents = Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->orderBy('nom')->orderBy('prenom')->get()
        : collect();
    $patientsCount = Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->count()
        : 0;
    $medecinsCount = Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->count()
        : 0;
    $medecinsActifsCount = Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->where('est_approuve', true)->count()
        : 0;
    $section = request()->string('section')->value();
    $medecins = $section === 'medecins' && Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->orderBy('nom')->get()
        : collect();
    $medecinEdit = $section === 'medecins' && request()->filled('edit') && Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->where('id_docteur', request()->string('edit')->value())->first()
        : null;
    $salleAttente = Schema::hasTable('SALLE_ATTENTE')
        ? DB::table('SALLE_ATTENTE')->join('PATIENT', 'PATIENT.id_patient', '=', 'SALLE_ATTENTE.id_patient')
            ->where('SALLE_ATTENTE.statut', 'En attente')
            ->orderBy('arrivee_at')->select('SALLE_ATTENTE.*', 'PATIENT.nom', 'PATIENT.prenom')->get()
        : collect();
    $patients = in_array($section, ['rendez-vous', 'patients'], true) && Schema::hasTable('PATIENT')
        ? DB::table('PATIENT')->orderBy('nom')->orderBy('prenom')->get()
        : collect();
    $patientEdit = $section === 'patients' && request()->filled('edit')
        ? DB::table('PATIENT')->where('id_patient', request()->string('edit')->value())->first()
        : null;
    $userEdit = $section === 'utilisateurs' && request()->filled('edit') && $user->isAdministrator()
        ? DB::table('UTILISATEUR')
            ->leftJoin('DOCTEUR', 'DOCTEUR.id_user', '=', 'UTILISATEUR.id_user')
            ->leftJoin('SERVICE', 'SERVICE.id_service', '=', 'UTILISATEUR.id_service')
            ->where('UTILISATEUR.id_user', request()->string('edit')->value())
            ->select('UTILISATEUR.*', 'DOCTEUR.specialite', 'DOCTEUR.telephone as docteur_telephone', 'SERVICE.nom_service', 'SERVICE.telephone as service_telephone')
            ->first()
        : null;
    $medecinsRendezVous = $section === 'rendez-vous' && Schema::hasTable('DOCTEUR')
        ? DB::table('DOCTEUR')->orderBy('nom')->orderBy('prenom')->get()
        : collect();
    $rendezVousEdit = $section === 'rendez-vous' && request()->filled('edit')
        ? DB::table('RENDEZ_VOUS')->where('id_rendez_vous', request()->string('edit')->value())->first()
        : null;
    $services = $section === 'services' && Schema::hasTable('SERVICE')
        ? DB::table('SERVICE')->orderBy('nom_service')->get()
        : collect();
    $serviceEdit = $section === 'services' && request()->filled('edit') && Schema::hasTable('SERVICE')
        ? DB::table('SERVICE')->where('id_service', request()->string('edit')->value())->first()
        : null;
    $etablissementSettings = $section === 'parametres' ? $etablissement : null;
    $carnets = collect();
    if ($section === 'carnets' && Schema::hasTable('PATIENT')) {
        $carnets = DB::table('PATIENT')
            ->orderBy('nom')->orderBy('prenom')->get()->map(function (object $patient): object {
                $consultations = Schema::hasTable('CONSULTATION')
                    ? DB::table('CONSULTATION')->where('id_patient', $patient->id_patient)->count() : 0;
                $analyses = Schema::hasTable('DEMANDE_ANALYSE')
                    ? DB::table('DEMANDE_ANALYSE')->where('id_patient', $patient->id_patient)->count()
                    : (Schema::hasTable('ANALYSE') ? DB::table('ANALYSE')->where('id_patient', $patient->id_patient)->count() : 0);
                $prescriptions = Schema::hasTable('PRESCRIPTION')
                    ? DB::table('PRESCRIPTION')->where('id_patient', $patient->id_patient)->count() : 0;
                $dates = collect();
                if (Schema::hasTable('CONSULTATION')) $dates->push(DB::table('CONSULTATION')->where('id_patient', $patient->id_patient)->max('created_at'));
                if (Schema::hasTable('DEMANDE_ANALYSE')) $dates->push(DB::table('DEMANDE_ANALYSE')->where('id_patient', $patient->id_patient)->max('demande_at'));
                if (Schema::hasTable('PRESCRIPTION')) $dates->push(DB::table('PRESCRIPTION')->where('id_patient', $patient->id_patient)->max('created_at'));
                $patient->activites = $consultations + $analyses + $prescriptions;
                $patient->derniere_activite = $dates->filter()->sortDesc()->first();
                return $patient;
            })->filter(fn (object $patient): bool => $patient->activites > 0)->values();
    }

    $utilisateurs = $user->isAdministrator() ? DB::table('UTILISATEUR')->leftJoin('ROLE', 'ROLE.id_role', '=', 'UTILISATEUR.id_role')->select('UTILISATEUR.*', 'ROLE.libelle_role')->orderBy('UTILISATEUR.nom')->get() : collect();
    $utilisateursCount = $user->isAdministrator() ? DB::table('UTILISATEUR')->count() : 0;
    return view('admin.dashboard', compact('user', 'etablissement', 'etablissementSettings', 'rendezVous', 'patientsRecents', 'patientsCount', 'medecinsCount', 'medecinsActifsCount', 'section', 'medecins', 'medecinEdit', 'patients', 'patientEdit', 'userEdit', 'medecinsRendezVous', 'periode', 'rendezVousEdit', 'services', 'serviceEdit', 'salleAttente', 'carnets', 'isSuperAdmin', 'utilisateurs', 'utilisateursCount'));
})->middleware('auth')->name('admin.dashboard');

Route::post('/admin/carnets/{id}/envoyer', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $etablissementId = healthPassEstablishmentId();
    $patient = DB::table('PATIENT')->where('id_patient', $id)->first();
    abort_unless($patient, 404);
    abort_unless($patient->email, 422, 'Ce patient ne possède pas d’adresse e-mail.');
    $etablissement = DB::table('ETABLISSEMENT')->first();
    $consultations = Schema::hasTable('CONSULTATION')
        ? DB::table('CONSULTATION')->join('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'CONSULTATION.id_docteur')
            ->where('CONSULTATION.id_patient', $id)->select('CONSULTATION.*', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->latest('date_consultation')->get()
        : collect();
    $analyses = Schema::hasTable('DEMANDE_ANALYSE')
        ? DB::table('DEMANDE_ANALYSE')->join('FORMAT', 'FORMAT.id_format', '=', 'DEMANDE_ANALYSE.id_format')->leftJoin('SERVICE', 'SERVICE.id_service', '=', 'DEMANDE_ANALYSE.id_service')->leftJoin('DOCTEUR', 'DOCTEUR.id_docteur', '=', 'DEMANDE_ANALYSE.id_docteur')->where('DEMANDE_ANALYSE.id_patient', $id)->select('DEMANDE_ANALYSE.*', DB::raw('COALESCE(FORMAT.type_examen, FORMAT.libelle_format) as type_analyse'), DB::raw('DEMANDE_ANALYSE.demande_at as date_analyse'), 'SERVICE.nom_service', 'DOCTEUR.nom as docteur_nom', 'DOCTEUR.prenom as docteur_prenom')->latest('demande_at')->get()
        : collect();
    $prescriptions = Schema::hasTable('PRESCRIPTION') ? DB::table('PRESCRIPTION')->where('id_patient', $id)->latest('date_prescription')->get() : collect();
    $pdf = Pdf::loadView('pdf.medical-record', compact('patient', 'etablissement', 'consultations', 'analyses', 'prescriptions'))->setPaper('a4');
    $pdfContents = $pdf->output();
    $mailConfigured = config('mail.default') !== 'smtp'
        || (filled(config('mail.mailers.smtp.username')) && filled(config('mail.mailers.smtp.password')));
    $emailFailed = false;
    if ($mailConfigured) {
        try {
            Mail::to($patient->email)->send(new \App\Mail\MedicalRecordMail(
                $pdfContents,
                trim($patient->prenom.' '.$patient->nom),
                'carnet-medical-'.$patient->id_patient.'.pdf',
                Auth::user()->email,
                trim(Auth::user()->prenom.' '.Auth::user()->nom),
                $etablissement->nom_etablissement ?? 'Votre établissement de santé',
            ));
        } catch (\Throwable $exception) {
            report($exception);
            $emailFailed = true;
        }
    }

    if ($emailFailed) {
        return to_route('admin.dashboard', ['section' => 'carnets'])
            ->with('error', 'Le carnet n’a pas pu être envoyé par e-mail : vérifiez la configuration SMTP et les identifiants du serveur mail.');
    }

    if ($mailConfigured) {
        return to_route('admin.dashboard', ['section' => 'carnets'])->with('success', 'Le carnet médical a été envoyé par e-mail au patient.');
    }

    return to_route('admin.dashboard', ['section' => 'carnets'])->with('success', 'Le carnet a été généré. Activez une configuration e-mail valide pour l’envoyer au patient.');
})->middleware('auth')->name('admin.medical-records.send');

Route::put('/admin/parametres', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $user = Auth::user();
    $validated = $request->validate([
        'nom_etablissement' => ['required', 'string', 'max:150'], 'adresse' => ['nullable', 'string', 'max:255'],
        'telephone' => ['nullable', 'string', 'max:30'], 'email_etablissement' => ['nullable', 'email', 'max:255'],
        'email_connexion' => ['required', 'email', 'max:255', Rule::unique('UTILISATEUR', 'email')->ignore($user->id_user, 'id_user')],
        'current_password' => ['required', 'string'], 'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);
    abort_unless(Hash::check($validated['current_password'], $user->mot_de_passe), 422, 'Mot de passe actuel incorrect.');
    DB::table('ETABLISSEMENT')->update([
        'nom_etablissement' => $validated['nom_etablissement'], 'adresse' => $validated['adresse'] ?? null,
        'telephone' => $validated['telephone'] ?? null, 'email_etablissement' => $validated['email_etablissement'] ?? null,
    ]);
    DB::table('UTILISATEUR')->where('id_user', $user->id_user)->update([
        'email' => $validated['email_connexion'], 'mot_de_passe' => filled($validated['new_password'] ?? null) ? Hash::make($validated['new_password']) : $user->mot_de_passe,
    ]);
    return to_route('admin.dashboard', ['section' => 'parametres'])->with('success', 'Les paramètres de l’établissement ont été enregistrés.');
})->middleware('auth')->name('admin.settings.update');

Route::post('/admin/rendez-vous', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'],
        'doctor_id' => ['required', 'string', 'exists:DOCTEUR,id_docteur'],
        'date' => ['required', 'date', 'after_or_equal:today'],
        'time' => ['required', 'date_format:H:i'],
        'reason' => ['nullable', 'string', 'max:150'],
    ]);
    $etablissementId = healthPassEstablishmentId();
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])->exists(), 422);
    abort_unless(DB::table('DOCTEUR')->where('id_docteur', $validated['doctor_id'])->exists(), 422);
    DB::table('RENDEZ_VOUS')->insert([
        'id_rendez_vous' => (string) Str::uuid(), 'id_patient' => $validated['patient_id'], 'id_docteur' => $validated['doctor_id'],
        'id_etablissement' => $etablissementId, 'date_rdv' => $validated['date'], 'heure_rdv' => $validated['time'],
        'motif' => $validated['reason'] ?? null, 'statut' => 'Planifié', 'created_at' => now(), 'updated_at' => now(),
    ]);
    return to_route('admin.dashboard', ['section' => 'rendez-vous'])->with('success', 'Le rendez-vous a été programmé.');
})->middleware('auth')->name('appointments.store');

Route::get('/admin/rendez-vous/{id}/edit', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $rendezVous = DB::table('RENDEZ_VOUS')
        ->where('id_rendez_vous', $id)
        ->first();
    abort_unless($rendezVous, 404);

    return to_route('admin.dashboard', [
        'section' => 'rendez-vous',
        'periode' => 'date',
        'date' => \Illuminate\Support\Carbon::parse($rendezVous->date_rdv)->format('Y-m-d'),
        'edit' => $rendezVous->id_rendez_vous,
    ]);
})->middleware('auth')->name('appointments.edit');

Route::delete('/admin/rendez-vous/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    DB::table('RENDEZ_VOUS')->where('id_rendez_vous', $id)->delete();
    return to_route('admin.dashboard', ['section' => 'rendez-vous'])->with('success', 'Le rendez-vous a été supprimé.');
})->middleware('auth')->name('appointments.destroy');

Route::put('/admin/rendez-vous/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'patient_id' => ['required', 'string', 'exists:PATIENT,id_patient'], 'doctor_id' => ['required', 'string', 'exists:DOCTEUR,id_docteur'],
        'date' => ['required', 'date', 'after_or_equal:today'], 'time' => ['required', 'date_format:H:i'], 'reason' => ['nullable', 'string', 'max:150'],
    ]);
    $etablissementId = healthPassEstablishmentId();
    $rendezVous = DB::table('RENDEZ_VOUS')->where('id_rendez_vous', $id)->first();
    abort_unless($rendezVous, 404);
    abort_unless(DB::table('PATIENT')->where('id_patient', $validated['patient_id'])->exists(), 422);
    abort_unless(DB::table('DOCTEUR')->where('id_docteur', $validated['doctor_id'])->exists(), 422);
    DB::table('RENDEZ_VOUS')->where('id_rendez_vous', $id)->update([
        'id_patient' => $validated['patient_id'], 'id_docteur' => $validated['doctor_id'], 'date_rdv' => $validated['date'], 'heure_rdv' => $validated['time'],
        'motif' => $validated['reason'] ?? null, 'updated_at' => now(),
    ]);
    $redirectParams = ['section' => 'rendez-vous', 'periode' => 'date', 'date' => $validated['date']];
    return to_route('admin.dashboard', $redirectParams)->with('success', 'Le rendez-vous a été modifié avec succès.');
})->middleware('auth')->name('appointments.update');

Route::post('/admin/services', function (Request $request) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom_service' => ['required', 'string', 'max:100'], 'type_service' => ['nullable', 'string', 'max:100'],
        'telephone' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255'],
    ]);
    $serviceCount = DB::table('SERVICE')->count();
    if ($serviceCount >= 15) {
        return back()->withErrors(['nom_service' => 'Un établissement ne peut contenir que 15 services maximum.'])->withInput();
    }

    $serviceData = $validated + ['id_service' => (string) Str::uuid(), 'id_etablissement' => healthPassEstablishmentId()];
    if (Schema::hasColumn('SERVICE', 'est_approuve')) {
        $serviceData['est_approuve'] = false;
    }
    if (Schema::hasColumn('SERVICE', 'est_actif')) {
        $serviceData['est_actif'] = false;
    }

    DB::table('SERVICE')->insert($serviceData);
    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été créé et doit être approuvé avant activation.');
})->middleware('auth')->name('services.store');

Route::put('/admin/services/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom_service' => ['required', 'string', 'max:100'], 'type_service' => ['nullable', 'string', 'max:100'],
        'telephone' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255'],
    ]);
    DB::table('SERVICE')->where('id_service', $id)->update($validated);
    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été modifié.');
})->middleware('auth')->name('services.update');

Route::delete('/admin/services/{id}', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    DB::table('SERVICE')->where('id_service', $id)->delete();
    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été supprimé.');
})->middleware('auth')->name('services.destroy');

Route::patch('/admin/services/{id}/approve', function (string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $service = DB::table('SERVICE')->where('id_service', $id)->first();
    abort_unless($service, 404);

    $updates = [];
    if (Schema::hasColumn('SERVICE', 'est_approuve')) {
        $updates['est_approuve'] = true;
    }
    if (Schema::hasColumn('SERVICE', 'est_actif')) {
        $updates['est_actif'] = true;
    }

    if ($updates !== []) {
        DB::table('SERVICE')->where('id_service', $id)->update($updates);
    }

    return to_route('admin.dashboard', ['section' => 'services'])->with('success', 'Le service a été approuvé et activé.');
})->middleware('auth')->name('services.approve');

Route::put('/admin/medecins/{id}', function (Request $request, string $id) {
    abort_unless(Auth::user()?->isAdministrator(), 403);
    $validated = $request->validate([
        'nom' => ['required', 'string', 'max:100'], 'prenom' => ['required', 'string', 'max:100'],
        'specialite' => ['nullable', 'string', 'max:100'], 'telephone' => ['nullable', 'string', 'max:30'],
        'email' => ['nullable', 'email', 'max:255'],
    ]);
    $doctor = DB::table('DOCTEUR')->where('id_docteur', $id)->first();
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
        ->first();
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
    DB::table('DOCTEUR')->where('id_docteur', $id)->delete();
    return to_route('admin.dashboard', ['section' => 'medecins'])->with('success', 'Le médecin a été supprimé.');
})->middleware('auth')->name('doctors.destroy');

Route::get('/admin/medecins', function () {
    return to_route('admin.dashboard', ['section' => 'medecins']);
})->middleware('auth')->name('admin.medecins');