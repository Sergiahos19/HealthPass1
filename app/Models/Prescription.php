<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $table = 'PRESCRIPTION';
    protected $primaryKey = 'id_prescription';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['id_prescription'];

    protected function casts(): array
    {
        return [
            'date_prescription' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'id_patient', 'id_patient');
    }
}
