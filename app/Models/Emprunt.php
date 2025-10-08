<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    use HasFactory;

    protected $fillable = [
        'livre_id',
        'usager_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effective',
        'notes'
    ];

    protected $casts = [
        'date_emprunt' => 'datetime',
        'date_retour_prevue' => 'datetime',
        'date_retour_effective' => 'datetime',
    ];

    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    public function usager()
    {
        return $this->belongsTo(Usager::class);
    }

    /**
     * Retourner le titre du livre en toute sécurité
     */
    public function getTitreLivreAttribute()
    {
        return $this->livre ? $this->livre->titre : 'Livre inconnu';
    }

    /**
     * Retourner le nom de l'usager en toute sécurité
     */
    public function getNomUsagerAttribute()
    {
        return $this->usager ? $this->usager->nom : 'Usager inconnu';
    }

    /**
     * Vérifier si l'emprunt peut être retourné
     */
    public function peutEtreRetourne()
    {
        return !$this->date_retour_effective && $this->livre;
    }
}