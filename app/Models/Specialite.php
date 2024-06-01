<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;
    public function cuisinier()
    {
        return $this->belongsTo(Cuisinier::class, 'Idcuisinier', 'id');
    }
}
