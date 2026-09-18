<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facture extends Model
{
    protected $table = 'FACTURE';
    protected $primaryKey = 'id_facture';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['id_facture'];

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'date_facture' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'id_patient', 'id_patient');
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'id_consultation', 'id_consultation');
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_caissier', 'id_user');
    }
}
