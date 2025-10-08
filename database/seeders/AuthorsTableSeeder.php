<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auteur;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auteurs = [
            [
                'nom' => 'Camara Laye',
                'biographie' => 'Écrivain guinéen, auteur de "L’Enfant noir", œuvre majeure de la littérature africaine francophone.'
            ],
            [
                'nom' => 'Mariama Bâ',
                'biographie' => 'Romancière sénégalaise, connue pour "Une si longue lettre", plaidoyer pour les droits des femmes.'
            ],
            [
                'nom' => 'Chinua Achebe',
                'biographie' => 'Auteur nigérian de "Le monde s’effondre", pionnier du roman africain moderne.'
            ],
            [
                'nom' => 'Fatou Diome',
                'biographie' => 'Écrivaine franco-sénégalaise, explore les thèmes de l’exil et de l’identité dans "Le Ventre de l’Atlantique".'
            ],
            [
                'nom' => 'Ahmadou Kourouma',
                'biographie' => 'Auteur ivoirien, célèbre pour "Allah n’est pas obligé", roman engagé sur les enfants soldats.'
            ],
        ];

        foreach ($auteurs as $auteur) {
            Auteur::create($auteur);
        }
    }
}