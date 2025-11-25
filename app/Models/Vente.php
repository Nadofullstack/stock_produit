<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Vente extends Model
{
    use HasFactory;
      protected $fillable = [
        'produit_id',
        'produit_nom',
        'quantite',
        'prix_unitaire',
        'total',
    ];
}
