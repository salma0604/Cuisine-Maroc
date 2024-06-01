<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;
    protected $table = 'utilisateurs';
    protected $fillable = [
        'nom', 'email', 'password','google_id','facebook_id','can_add_photo',
    ];
    public function estCuisinier()
    {
        return $this->hasOne(Cuisinier::class, 'IdUtilisateur');
    }
}
