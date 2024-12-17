<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPound extends Model
{
    use HasFactory;

    
    protected $table = 'sellpound';

    protected $fillable = [
        'user_id', 'nom_coli', 'pays_depart', 'ville_depart', 'aeroport_depart', 'date_depart',
        'pays_destination', 'ville_destination', 'aeroport_destination', 'date_arrive',
        'poid', 'img_tiket_embarquement', 'numero_telephone', 'img_passeport', 'photo'
    ];

    // Relier un SellPound à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
