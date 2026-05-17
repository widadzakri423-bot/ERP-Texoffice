<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intervention extends Model
{
    protected $fillable = [
        'machine_id',
        'date_intervention',
        'description',
        'cout',
        'type',
        'technicien',
        'pieces_remplacees',
    ];

    protected $casts = [
        'date_intervention' => 'date',
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }
}