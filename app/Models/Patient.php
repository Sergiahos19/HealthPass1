<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $table = 'PATIENT';
    protected $primaryKey = 'id_patient';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $guarded = ['id_patient'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'id_patient', 'id_patient');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'id_patient', 'id_patient');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Facture::class, 'id_patient', 'id_patient');
    }
}
