<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usager extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'profession',
        'identifiant',
        'adresse',
        'telephone',
        'quartier'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relation avec les emprunts (si nécessaire)
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }
}