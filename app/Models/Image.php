<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    // Relation avec le modèle Cuisinier
    public function cuisinier()
    {
        return $this->belongsTo(Cuisinier::class, 'Idcuisinier', 'id');
    }
}
