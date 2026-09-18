@include('pdf.medical-record', [
    'patient' => $patient ?? null,
    'etablissement' => $etablissement ?? null,
    'consultations' => $consultations ?? collect(),
    'analyses' => $analyses ?? collect(),
    'prescriptions' => $prescriptions ?? collect(),
])
