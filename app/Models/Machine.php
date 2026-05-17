<?php

namespace App\Models;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    //
    use LogsActivity;
     protected $fillable = [
        'reference',
        'designation',
        'marque',
        'modele',
        'etat',
        'date_acquisition',
        'cout_heure',
        'notes',
    ];

    protected $casts = [
        'date_acquisition' => 'date',
    ];
    

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class);
    }
}
