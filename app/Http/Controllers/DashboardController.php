<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Emprunt;
use App\Models\Usager; // Remplacer Reservation par Usager
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'livres' => Livre::count(),
            'emprunts' => Emprunt::count(),
            'usagers' => Usager::count(), // Remplacer reservations par usagers
            'enCours' => Emprunt::whereNull('date_retour_effective')->count(),
            'retards' => Emprunt::with('usager')->where('date_retour_prevue', '<', now())->whereNull('date_retour_effective')->count(),
        ];

        $totalLivres = Livre::count();
        $totalEmprunts = Emprunt::count();
        $totalUsagers = Usager::count(); // Remplacer totalReservations par totalUsagers
        $empruntsEnCours = Emprunt::with('usager')->whereNull('date_retour_effective')->count();
        $empruntsEnRetard = Emprunt::where('date_retour_prevue', '<', now())
            ->whereNull('date_retour_effective')
            ->count();

        $derniersEmprunts = Emprunt::with(['livre', 'usager'])
            ->whereNull('date_retour_effective')
            ->orderBy('date_emprunt', 'desc')
            ->limit(5)
            ->get();

        // Supprimer les références aux réservations
        $livresPopulaires = Livre::withCount('emprunts')
            ->orderBy('emprunts_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalLivres',
            'totalEmprunts',
            'totalUsagers', // Remplacer totalReservations
            'empruntsEnCours',
            'empruntsEnRetard',
            'derniersEmprunts',
            'stats',
            'livresPopulaires'
        ));
    }
}