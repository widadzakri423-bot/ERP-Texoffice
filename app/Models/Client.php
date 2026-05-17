<?php

namespace App\Models;
use App\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    use LogsActivity;
    protected $fillable = [
        'raison_sociale',
        'email',
        'telephone',
        'adresse',
        'ville',
    ];

    public function devis()
    {
        return $this->hasMany(Devis::class);
    }
}
