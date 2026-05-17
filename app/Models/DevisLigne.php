<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevisLigne extends Model
{
    //
    protected $table = 'devis_lignes';

    protected $fillable = [
        'devis_id',
        'article_id',
        'designation',
        'quantite',
        'prix_unitaire',
        'remise_ligne',
        'total_ligne',
    ];

    protected $casts = [
        'quantite' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'remise_ligne' => 'decimal:2',
        'total_ligne' => 'decimal:2',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
