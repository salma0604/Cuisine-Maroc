<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuisinier extends Model
{
    use HasFactory;

    protected $table = 'cuisiniers'; // Le nom de votre table de cuisiniers

    // Relation avec les vidéos
    // public function videos()
    // {
    //     return $this->hasMany(Video::class, 'IdCuisinier');
    // }
    public function Images(){

        return $this->hasMany(Image::class,'IdCuisinier');
    }
    public function Specialite(){

        return $this->hasMany(Specialite::class,'IdCuisinier');
    }
    public function Utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
