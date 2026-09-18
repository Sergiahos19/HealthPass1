<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        margin: 0;
        padding: 0;
        color: #14213d;
        background: #ffffff;
        font-size: 10px;
    }
    .page {
        padding: 24px;
    }
    .header {
        border-bottom: 2px solid #dfe7ee;
        padding-bottom: 12px;
        margin-bottom: 18px;
    }
    h1 {
        margin: 0;
        color: #0f766e;
        font-size: 24px;
    }
    .subtitle {
        margin: 6px 0 0;
        color: #475569;
        font-size: 10px;
    }
    .patient-box {
        background: #f8fafc;
        border: 1px solid #dfe7ee;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 18px;
    }
    .patient-box strong {
        color: #0f172a;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        border: 1px solid #cfe1e8;
    }
    th, td {
        border: 1px solid #dfe7ee;
        vertical-align: top;
        padding: 8px 7px;
        word-wrap: break-word;
        text-align: left;
    }
    th {
        background: #e0f2f1;
        color: #0f172a;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    tbody tr:last-child td {
        border-bottom: 2px solid #22c55e;
    }
    .last-row td {
        background: rgba(34, 197, 94, 0.06);
        border-bottom: 2px solid #22c55e;
    }
    .muted {
        color: #64748b;
    }
    .line-block {
        display: block;
        margin-bottom: 4px;
    }
</style>
</head>
<body>
@php
    $grouped = [];
    $formatDateKey = fn ($value) => $value ? \Illuminate\Support\Carbon::parse($value)->format('Y-m-d') : 'non-date';
    $normalizeText = fn ($value) => mb_strtolower(preg_replace('/\s+/', ' ', trim((string) $value)));

    $addEntry = function (string $dateKey, string $column, string $value) use (&$grouped): void {
        if (trim($value) === '') {
            return;
        }

        $dateKey = $dateKey ?: 'non-date';
        $grouped[$dateKey] ??= [
            'date' => $dateKey,
            'consultations' => [],
            'analyses' => [],
            'resultats' => [],
            'prescriptions' => [],
        ];

        $grouped[$dateKey][$column][] = trim($value);
    };

    $formatList = function (array $items, string $prefix = '•') use ($normalizeText): string {
        $list = collect($items)
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '')
            ->unique(fn ($item) => $normalizeText($item))
            ->values()
            ->all();

        if ($list === []) {
            return '—';
        }

        return implode("\n", array_map(function ($item) use ($prefix) {
            if (str_starts_with($item, '• ') || str_starts_with($item, '* ')) {
                return $item;
            }

            return $prefix.' '.$item;
        }, $list));
    };

    $consultationItems = [];
    foreach ($consultations as $consultation) {
        $dateKey = $formatDateKey($consultation->date_consultation ?? null);
        $consultationText = collect([
            $consultation->docteur_prenom && $consultation->docteur_nom ? 'Médecin : Dr '.$consultation->docteur_prenom.' '.$consultation->docteur_nom : null,
            $consultation->motif ? 'Motif : '.$consultation->motif : null,
            $consultation->diagnostic ? 'Diagnostic : '.$consultation->diagnostic : null,
            $consultation->traitement ? 'Traitement : '.$consultation->traitement : null,
            $consultation->observation_medicale ? 'Observations : '.$consultation->observation_medicale : null,
        ])->map(fn ($value) => trim((string) $value))->filter()->all();

        if ($consultationText !== []) {
            $addEntry($dateKey, 'consultations', implode("\n", $consultationText));
        }
    }

    foreach ($analyses as $analyse) {
        $dateKey = $formatDateKey($analyse->date_analyse ?? $analyse->demande_at ?? null);
        $analysisText = collect([
            $analyse->type_analyse ? $analyse->type_analyse : null,
            $analyse->nom_service ? 'Service : '.$analyse->nom_service : null,
            $analyse->statut ? 'Statut : '.$analyse->statut : null,
        ])->map(fn ($value) => trim((string) $value))->filter()->all();

        if ($analysisText !== []) {
            $addEntry($dateKey, 'analyses', implode("\n", $analysisText));
        }

        if (! empty($analyse->resultat)) {
            $addEntry($dateKey, 'resultats', 'Résultat : '.$analyse->resultat);
        }
    }

    $seenPrescriptions = [];
    foreach ($prescriptions as $prescription) {
        $dateKey = $formatDateKey($prescription->date_prescription ?? null);
        $medicament = trim((string) ($prescription->medicament ?? ''));
        $dosage = trim((string) ($prescription->dosage ?? ''));
        $frequence = trim((string) ($prescription->frequence ?? ''));
        $duree = trim((string) ($prescription->duree_jours ?? ''));
        $dureeLabel = $duree !== '' ? 'Durée : '.$duree.' jour(s)' : null;

        $parts = array_filter([
            $medicament,
            $dosage !== '' ? $dosage : null,
            $frequence !== '' ? $frequence : null,
            $dureeLabel,
        ], fn ($value) => $value !== null && trim((string) $value) !== '');

        if ($parts === []) {
            continue;
        }

        $normalized = $normalizeText(implode(' | ', $parts));
        if (isset($seenPrescriptions[$dateKey][$normalized])) {
            continue;
        }

        $seenPrescriptions[$dateKey][$normalized] = true;
        $addEntry($dateKey, 'prescriptions', "• ".implode("\n", $parts));
    }

    $rows = collect($grouped)->map(function ($entry) use ($normalizeText, $formatList) {
        $dateKey = $entry['date'];
        $dateSort = $dateKey !== 'non-date' ? \Illuminate\Support\Carbon::parse($dateKey)->timestamp : 0;
        $formattedDate = $dateKey !== 'non-date' && $dateKey
            ? \Illuminate\Support\Carbon::parse($dateKey)->format('d/m/Y')
            : '—';

        return [
            'date_key' => $dateKey,
            'date_sort' => $dateSort,
            'date_label' => $formattedDate,
            'consultations' => $formatList($entry['consultations'], '•'),
            'analyses' => $formatList($entry['analyses'], '•'),
            'resultats' => $formatList($entry['resultats'], '•'),
            'prescriptions' => $formatList($entry['prescriptions'], '•'),
        ];
    })->sortBy('date_sort')->values();

    if ($rows->isEmpty()) {
        $rows->push([
            'date_key' => now()->toDateString(),
            'date_sort' => now()->timestamp,
            'date_label' => now()->format('d/m/Y'),
            'consultations' => 'Aucune donnée enregistrée',
            'analyses' => '—',
            'resultats' => '—',
            'prescriptions' => '—',
        ]);
    }
@endphp

<div class="page">
    <div class="header">
        <h1>{{ $etablissement->nom_etablissement ?? 'Établissement de santé' }}</h1>
        <p class="subtitle">Carnet médical confidentiel · Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="patient-box">
        <div><strong>{{ $patient->prenom }} {{ $patient->nom }}</strong></div>
        <div class="muted">N° patient : {{ $patient->npi ?: $patient->id_patient }}</div>
        <div class="muted">Email : {{ $patient->email ?: 'Non renseigné' }}</div>
        <div class="muted">Date de naissance : {{ $patient->date_naissance ? \Illuminate\Support\Carbon::parse($patient->date_naissance)->format('d/m/Y') : 'Non renseignée' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Date</th>
                <th style="width: 24%;">Consultations</th>
                <th style="width: 24%;">Analyses et/ou examens</th>
                <th style="width: 20%;">Résultats</th>
                <th style="width: 20%;">Prescriptions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr class="{{ $loop->last ? 'last-row' : '' }}">
                    <td>{{ $row['date_label'] }}</td>
                    <td>{!! nl2br(e($row['consultations'])) !!}</td>
                    <td>{!! nl2br(e($row['analyses'])) !!}</td>
                    <td>{!! nl2br(e($row['resultats'])) !!}</td>
                    <td>{!! nl2br(e($row['prescriptions'])) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
