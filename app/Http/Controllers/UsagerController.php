<?php

namespace App\Http\Controllers;

use App\Models\Usager;
use Illuminate\Http\Request;

class UsagerController extends Controller
{
    public function index()
    {
        $usagers = Usager::orderBy('nom')->paginate(20);
        return view('usagers.index', compact('usagers'));
    }

    public function create()
    {
        return view('usagers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'identifiant' => 'required|string|max:255|unique:usagers',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'quartier' => 'required|string|max:255'
        ]);

        Usager::create($validated);

        return redirect()->route('usagers.index')
            ->with('success', 'Usager créé avec succès.');
    }

    public function show(Usager $usager)
    {
        return view('usagers.show', compact('usager'));
    }

    public function edit(Usager $usager)
    {
        return view('usagers.edit', compact('usager'));
    }

    public function update(Request $request, Usager $usager)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'identifiant' => 'required|string|max:255|unique:usagers,identifiant,' . $usager->id,
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'quartier' => 'required|string|max:255'
        ]);

        $usager->update($validated);

        return redirect()->route('usagers.show', $usager)
            ->with('success', 'Usager mis à jour avec succès.');
    }

    public function destroy(Usager $usager)
    {
        $usager->delete();

        return redirect()->route('usagers.index')
            ->with('success', 'Usager supprimé avec succès.');
    }
}