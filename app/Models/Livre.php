<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'titre',
        'description',
        'auteur_id',
        'categorie_id',
        'annee_publication',
        'editeur',
        'exemplaires_total',
        'exemplaires_disponibles',
        'image_couverture'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

    public function usagers()
    {
        return $this->hasMany(Usager::class);
    }
}