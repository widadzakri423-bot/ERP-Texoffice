<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model
{
    //
    protected $fillable = [
        'article_id',
        'type',
        'quantite',
        'prix_unitaire',
        'devis_id',
        'user_id',
        'motif',
        'date_mouvement',
    ];

    protected $casts = [
        'date_mouvement' => 'date',
        'quantite' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
