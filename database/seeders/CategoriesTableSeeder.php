<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Roman', 'description' => 'Œuvre de fiction longue avec intrigue et personnages développés.'],
            ['nom' => 'Nouvelle', 'description' => 'Récit court centré sur un événement ou une chute.'],
            ['nom' => 'Conte', 'description' => 'Récit merveilleux ou fantastique, souvent moral.'],
            ['nom' => 'Poésie', 'description' => 'Texte en vers ou prose poétique, jouant sur le rythme et les images.'],
            ['nom' => 'Théâtre', 'description' => 'Texte destiné à être joué, composé de dialogues.'],
            ['nom' => 'Essai', 'description' => 'Réflexion personnelle sur un sujet, souvent argumentée.'],
            ['nom' => 'Biographie', 'description' => 'Récit de la vie d’une personne réelle.'],
            ['nom' => 'Autobiographie', 'description' => 'Récit de la vie de l’auteur, écrit par lui-même.'],
            ['nom' => 'Documentaire', 'description' => 'Livre informatif basé sur des faits réels.'],
            ['nom' => 'Livre scientifique', 'description' => 'Présente des concepts ou recherches dans un domaine précis.'],
            ['nom' => 'Livre historique', 'description' => 'Analyse ou récit d’événements passés.'],
            ['nom' => 'Livre religieux', 'description' => 'Texte sacré ou spirituel.'],
            ['nom' => 'Livre scolaire', 'description' => 'Manuel structuré pour l’apprentissage.'],
            ['nom' => 'Livre jeunesse', 'description' => 'Adapté aux enfants ou adolescents, souvent illustré.'],
            ['nom' => 'Livre pratique', 'description' => 'Guide sur un savoir-faire (cuisine, jardinage, etc.).'],
            ['nom' => 'Développement personnel', 'description' => 'Méthodes pour améliorer sa vie ou sa carrière.'],
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}