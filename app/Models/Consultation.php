<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $table = 'CONSULTATION';
    protected $primaryKey = 'id_consultation';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['id_consultation'];

    protected function casts(): array
    {
        return [
            'date_consultation' => 'date',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'id_patient', 'id_patient');
    }
}
