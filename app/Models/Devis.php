<?php

namespace App\Models;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Devis extends Model
{
    //
    use LogsActivity;

    protected $table = 'devis';

    protected $fillable = [
        'numero',
        'client_id',
        'user_id',
        'statut',
        'date_creation',
        'date_validite',
        'remise_globale',
        'montant_ht',
        'tva',
        'montant_ttc',
        'notes',
    ];

    protected $casts = [
        'date_creation' => 'date',
        'date_validite' => 'date',
        'remise_globale' => 'decimal:2',
        'montant_ht' => 'decimal:2',
        'tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lignes()
    {
        return $this->hasMany(DevisLigne::class);
    }

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class);
    }
    

// ... dans la classe Devis ...

public function machines(): BelongsToMany
{
    return $this->belongsToMany(Machine::class, 'devis_machine')
                ->withPivot('nb_heures', 'cout_total')
                ->withTimestamps();
}
}
