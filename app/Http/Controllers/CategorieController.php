<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('livres')->paginate(20);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Debug: afficher les données reçues
        log::info('Données reçues:', $request->all());

        try {
            $validated = $request->validate([
                'nom' => 'required|max:255|unique:categories',
                'description' => 'nullable'
            ]);

            log::info('Données validées:', $validated);

            $categorie = Categorie::create($validated);

            log::info('Catégorie créée:', $categorie->toArray());

            return redirect()->route('categories.index')
                ->with('success', 'Catégorie ajoutée avec succès.');
        } catch (\Exception $e) {
            log::error('Erreur création catégorie: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function show(Categorie $categorie)
    {
        $categorie->load('livres');
        return view('categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable'
        ]);

        $categorie->update($validated);

        return redirect()->route('categories.show', $categorie)
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        if ($categorie->livres()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Impossible de supprimer cette catégorie : elle a des livres associés.');
        }

        $categorie->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
