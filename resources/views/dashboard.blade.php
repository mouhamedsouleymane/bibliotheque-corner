@extends('layouts.app')

@section('title', 'Tableau de bord - Gestion de Bibliothèque')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Tableau de bord</h1>
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-filter"></i> Filtres
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                    <li><a class="dropdown-item" href="#">Cette semaine</a></li>
                    <li><a class="dropdown-item" href="#">Ce mois</a></li>
                </ul>
            </div>
        </div>

        <!-- Cartes de statistiques -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total des livres
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLivres }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-book fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Emprunts en cours
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $empruntsEnCours }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-cart-check fs-1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Retards</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $empruntsEnRetard }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Usagers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsagers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille des tableaux -->
        <div class="row">
            <!-- Derniers emprunts -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Derniers emprunts</h6>
                        <a href="{{ route('emprunts.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($derniersEmprunts as $emprunt)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $emprunt->livre->titre }}</h6>
                                        <small class="text-muted">Emprunté par {{ $emprunt->usager?->nom ?? 'Usager inconnu' }}</small>
                                    </div>
                                    <div class="text-end">
                                        <small
                                            class="text-muted d-block">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</small>
                                        <span
                                            class="badge bg-{{ $emprunt->date_retour_prevue < now() ? 'danger' : 'secondary' }}">
                                            Retour:
                                            {{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mt-2">Aucun emprunt récent</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livres populaires -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Livres populaires</h6>
                        <a href="{{ route('livres.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($livresPopulaires as $livre)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $livre->titre }}</h6>
                                        <small class="text-muted">{{ $livre->auteur->nom }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">
                                            {{ $livre->emprunts_count }} emprunts
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mt-2">Aucun livre populaire</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions rapides</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('livres.create') }}"
                                    class="btn btn-primary btn-lg p-3 w-100 d-flex flex-column align-items-center">
                                    <i class="bi bi-plus-circle fs-1 mb-2"></i>
                                    <span>Ajouter un livre</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('emprunts.create') }}"
                                    class="btn btn-success btn-lg p-3 w-100 d-flex flex-column align-items-center">
                                    <i class="bi bi-cart-plus fs-1 mb-2"></i>
                                    <span>Nouvel emprunt</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('usagers.create') }}"
                                    class="btn btn-info btn-lg p-3 w-100 d-flex flex-column align-items-center">
                                    <i class="bi bi-person-plus fs-1 mb-2"></i>
                                    <span>Nouvel usager</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('livres.index') }}"
                                    class="btn btn-warning btn-lg p-3 w-100 d-flex flex-column align-items-center">
                                    <i class="bi bi-collection fs-1 mb-2"></i>
                                    <span>Gérer les livres</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et statistiques avancées -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Activité récente</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="activityChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Catégories populaires</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="categoryChart" height="200"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="bi bi-circle-fill text-primary"></i> Fiction
                            </span>
                            <span class="mr-2">
                                <i class="bi bi-circle-fill text-success"></i> Science
                            </span>
                            <span class="mr-2">
                                <i class="bi bi-circle-fill text-info"></i> Histoire
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Graphique d'activité (exemple)
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('activityChart').getContext('2d');
            var activityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [{
                        label: 'Emprunts',
                        data: [12, 19, 8, 15, 10, 5, 9],
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            // Graphique circulaire des catégories (exemple)
            var ctx2 = document.getElementById('categoryChart').getContext('2d');
            var categoryChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Fiction', 'Science', 'Histoire', 'Autres'],
                    datasets: [{
                        data: [35, 25, 20, 20],
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .shadow {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .text-xs {
            font-size: 0.7rem;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .btn-action {
            transition: all 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #e3e6f0;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection
