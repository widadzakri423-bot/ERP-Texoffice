<?php

namespace App\Models;
use App\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    use LogsActivity;
    protected $fillable = [
        'reference',
        'designation',
        'categorie',
        'unite',
        'quantite_stock',
        'seuil_minimum',
        'prix_unitaire',
        'emplacement',
        'notes',
    ];

    public function devisLignes()
    {
        return $this->hasMany(DevisLigne::class);
    }

    public function mouvements()
    {
        return $this->hasMany(Mouvement::class);
    }
}
