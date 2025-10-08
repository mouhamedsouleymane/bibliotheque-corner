<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    public function index(Request $request)
    {
        $query = Livre::with(['auteur', 'categorie']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%$search%")
                    ->orWhere('isbn', 'like', "%$search%")
                    ->orWhereHas('auteur', function ($q) use ($search) {
                        $q->where('nom', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('categorie') && $request->categorie != '') {
            $query->where('categorie_id', $request->categorie);
        }

        $livres = $query->paginate(20);
        $categories = Categorie::all();

        return view('livres.index', compact('livres', 'categories'));
    }

    public function create()
    {
        $auteurs = Auteur::all();
        $categories = Categorie::all();
        return view('livres.create', compact('auteurs', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:livres',
            'titre' => 'required|max:255',
            'auteur_id' => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'annee_publication' => 'required|integer|min:1900|max:' . date('Y'),
            'editeur' => 'required|max:255',
            'exemplaires_total' => 'required|integer|min:1',
            'description' => 'nullable'
        ]);

        $validated['exemplaires_disponibles'] = $validated['exemplaires_total'];

        if ($request->hasFile('image_couverture')) {
            $path = $request->file('image_couverture')->store('couvertures', 'public');
            $validated['image_couverture'] = $path;
        }

        Livre::create($validated);

        return redirect()->route('livres.index')
            ->with('success', 'Livre ajouté avec succès.');
    }

    public function show(Livre $livre)
    {
        // Récupérer les emprunts du livre avec les usagers associés
        $emprunts = $livre->emprunts()->with('usager')->get();

        // Extraire les usagers uniques
        $usagers = $emprunts->pluck('usager')->unique('id');

        return view('livres.show', compact('livre', 'usagers', 'emprunts'));
    }


    public function edit(Livre $livre)
    {
        $auteurs = Auteur::all();
        $categories = Categorie::all();
        return view('livres.edit', compact('livre', 'auteurs', 'categories'));
    }

    public function update(Request $request, Livre $livre)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:livres,isbn,' . $livre->id,
            'titre' => 'required|max:255',
            'auteur_id' => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'annee_publication' => 'required|integer|min:1900|max:' . date('Y'),
            'editeur' => 'required|max:255',
            'exemplaires_total' => 'required|integer|min:1',
            'description' => 'nullable'
        ]);

        // Calculer les exemplaires disponibles
        $empruntesCount = $livre->emprunts()->whereNull('date_retour_effective')->count();
        $newAvailable = $validated['exemplaires_total'] - $empruntesCount;

        if ($newAvailable < 0) {
            return back()->withErrors(['exemplaires_total' => 'Le nombre total ne peut pas être inférieur aux exemplaires empruntés.']);
        }

        $validated['exemplaires_disponibles'] = $newAvailable;

        if ($request->hasFile('image_couverture')) {
            // Supprimer l'ancienne image si elle existe
            if ($livre->image_couverture) {
                Storage::disk('public')->delete($livre->image_couverture);
            }

            $path = $request->file('image_couverture')->store('couvertures', 'public');
            $validated['image_couverture'] = $path;
        }

        $livre->update($validated);

        return redirect()->route('livres.index')
            ->with('success', 'Livre mis à jour avec succès.');
    }

    public function destroy(Livre $livre)
    {
        // Vérifier s'il y a des emprunts en cours
        if ($livre->emprunts()->whereNull('date_retour_effective')->exists()) {
            return redirect()->route('livres.index')
                ->with('error', 'Impossible de supprimer le livre : des exemplaires sont encore empruntés.');
        }

        // Supprimer l'image si elle existe
        if ($livre->image_couverture) {
            Storage::disk('public')->delete($livre->image_couverture);
        }

        $livre->delete();

        return redirect()->route('livres.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
}