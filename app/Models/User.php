<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Ajouté pour la gestion des tokens API

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Attributs modifiables en masse.
     */
    protected $fillable = [
        'nom', 'prenom', 'age', 'sexe', 'email', 'adresse', 'nationalite', 'password',
    ];

    /**
     * Attributs à cacher lors de la sérialisation.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Cast des attributs.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutateur pour hasher le mot de passe automatiquement.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
