<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Usager;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpruntController extends Controller
{
    public function index()
    {
        $emprunts = Emprunt::with(['livre', 'usager'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('emprunts.index', compact('emprunts'));
    }

    public function create()
    {
        $livres = Livre::where('exemplaires_disponibles', '>', 0)->get();
        $usagers = Usager::all();

        return view('emprunts.create', compact('livres', 'usagers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'livre_id' => 'required|exists:livres,id',
            'usager_id' => 'required|exists:usagers,id',
            'date_retour_prevue' => 'required|date|after:today'
        ]);

        $livre = Livre::find($validated['livre_id']);

        if ($livre->exemplaires_disponibles < 1) {
            return back()->withErrors(['error' => 'Ce livre n\'est plus disponible.']);
        }

        $existingEmprunt = Emprunt::where('livre_id', $validated['livre_id'])
            ->where('usager_id', $validated['usager_id'])
            ->whereNull('date_retour_effective')
            ->first();

        if ($existingEmprunt) {
            return back()->withErrors(['error' => 'Cet usager a déjà emprunté ce livre.']);
        }

        Emprunt::create([
            'livre_id' => $validated['livre_id'],
            'usager_id' => $validated['usager_id'],
            'date_emprunt' => Carbon::now(),
            'date_retour_prevue' => $validated['date_retour_prevue']
        ]);

        $livre->decrement('exemplaires_disponibles');

        return redirect()->route('emprunts.index')
            ->with('success', 'Emprunt enregistré avec succès.');
    }

    /**
     * Marquer un emprunt comme retourné
     */
    public function retourner(Emprunt $emprunt)
    {
        // Charger les relations nécessaires
        $emprunt->load(['livre', 'usager']);

        // Vérifier si l'emprunt existe
        if (!$emprunt) {
            return redirect()->route('emprunts.index')
                ->with('error', 'Emprunt non trouvé.');
        }

        // Vérifier si déjà retourné
        if ($emprunt->date_retour_effective) {
            return redirect()->route('emprunts.index')
                ->with('error', 'Cet emprunt a déjà été retourné le ' .
                    ($emprunt->date_retour_effective ? $emprunt->date_retour_effective->format('d/m/Y') : 'date inconnue'));
        }

        // Vérifier que le livre existe
        if (!$emprunt->livre) {
            return redirect()->route('emprunts.index')
                ->with('error', 'Livre non trouvé pour cet emprunt.');
        }

        try {
            // Utiliser une transaction pour garantir l'intégrité des données
            DB::transaction(function () use ($emprunt) {
                // Marquer l'emprunt comme retourné
                $emprunt->update([
                    'date_retour_effective' => Carbon::now()
                ]);

                // Remettre le livre en stock
                $emprunt->livre->increment('exemplaires_disponibles');
            });

            // Recharger l'emprunt avec les données fraîches
            $emprunt->refresh();

            // Message de succès
            return redirect()->route('emprunts.index')
                ->with('success', 'Livre "' . $emprunt->livre->titre . '" retourné avec succès. ' .
                    'Exemplaires disponibles : ' . $emprunt->livre->exemplaires_disponibles);
        } catch (\Exception $e) {
            // Message d'erreur en cas de problème
            Log::error('Erreur retour emprunt', [
                'emprunt_id' => $emprunt->id,
                'erreur' => $e->getMessage()
            ]);

            return redirect()->route('emprunts.index')
                ->with('error', 'Erreur lors du retour du livre : ' . $e->getMessage());
        }
    }

    public function show(Emprunt $emprunt)
    {
        $emprunt->load(['livre', 'usager']);
        return view('emprunts.show', compact('emprunt'));
    }

    public function edit(Emprunt $emprunt)
    {
        $emprunt->load(['livre', 'usager']);
        return view('emprunts.edit', compact('emprunt'));
    }

    public function update(Request $request, Emprunt $emprunt)
    {
        $validated = $request->validate([
            'date_emprunt' => 'required|date',
            'date_retour_prevue' => 'required|date|after:date_emprunt',
            'date_retour_effective' => 'nullable|date|after:date_emprunt',
            'notes' => 'nullable|string'
        ]);

        $emprunt->update($validated);

        return redirect()->route('emprunts.show', $emprunt)
            ->with('success', 'Emprunt mis à jour avec succès.');
    }

    public function destroy(Emprunt $emprunt)
    {
        // Si l'emprunt n'est pas retourné, remettre le livre en stock
        if (!$emprunt->date_retour_effective && $emprunt->livre) {
            $emprunt->livre->increment('exemplaires_disponibles');
        }

        $titreLivre = $emprunt->livre->titre;
        $emprunt->delete();

        return redirect()->route('emprunts.index')
            ->with('success', 'Emprunt pour "' . $titreLivre . '" supprimé avec succès.');
    }
}