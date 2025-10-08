<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use Illuminate\Http\Request;

class AuteurController extends Controller
{
    public function index()
    {
        $auteurs = Auteur::withCount('livres')->paginate(20);
        return view('auteurs.index', compact('auteurs'));
    }

    public function create()
    {
        return view('auteurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'biographie' => 'nullable'
        ]);

        Auteur::create($validated);

        return redirect()->route('auteurs.index')
            ->with('success', 'Auteur ajouté avec succès.');
    }

    public function show(Auteur $auteur)
    {
        $auteur->load('livres');
        return view('auteurs.show', compact('auteur'));
    }

    public function edit(Auteur $auteur)
    {
        return view('auteurs.edit', compact('auteur'));
    }

    public function update(Request $request, Auteur $auteur)
    {
        $validated = $request->validate([
            'nom' => 'required|max:255',
            'biographie' => 'nullable'
        ]);

        $auteur->update($validated);

        return redirect()->route('auteurs.show', $auteur)
            ->with('success', 'Auteur mis à jour avec succès.');
    }

    public function destroy(Auteur $auteur)
    {
        // Empêcher la suppression si l'auteur a des livres
        if ($auteur->livres()->count() > 0) {
            return redirect()->route('auteurs.index')
                ->with('error', 'Impossible de supprimer cet auteur : il a des livres associés.');
        }

        $auteur->delete();

        return redirect()->route('auteurs.index')
            ->with('success', 'Auteur supprimé avec succès.');
    }
}
