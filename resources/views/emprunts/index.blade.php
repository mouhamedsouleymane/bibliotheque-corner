@extends('layouts.app')

@section('title', 'Gestion des emprunts')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h2 mb-0">
                        <i class="bi bi-book me-2"></i>Gestion des emprunts
                    </h1>
                    <a href="{{ route('emprunts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Nouvel emprunt
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages de session -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Cartes de statistiques -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total emprunts</h5>
                                <p class="card-text h4">{{ $emprunts->total() }}</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-book h3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">En cours</h5>
                                <p class="card-text h4">
                                    {{ $emprunts->where('date_retour_effective', null)->where('date_retour_prevue', '>=', now())->count() }}
                                </p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-clock h3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">En retard</h5>
                                <p class="card-text h4">
                                    {{ $emprunts->where('date_retour_effective', null)->where('date_retour_prevue', '<', now())->count() }}
                                </p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-exclamation-triangle h3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">Liste des emprunts</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Livre</th>
                                <th scope="col">Usager</th>
                                <th scope="col">Date d'emprunt</th>
                                <th scope="col">Retour prévu</th>
                               
                                <th scope="col">Statut</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($emprunts as $emprunt)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}
                                        </div>
                                        <small class="text-muted">ISBN: {{ $emprunt->livre->isbn ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $emprunt->usager->nom ?? 'Usager inconnu' }}</div>
                                        <small class="text-muted">ID: {{ $emprunt->usager->id ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>
                                        <span
                                            class="{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue->isPast()) && !$emprunt->date_retour_effective ? 'text-danger fw-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    
                                    <td>
                                        @if ($emprunt->date_retour_effective)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> Retourné
                                            </span>
                                        @elseif($emprunt->date_retour_prevue->isPast())
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-triangle me-1"></i> En retard
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s) de retard
                                            </small>
                                        @else
                                            <span class="badge bg-primary">
                                                <i class="bi bi-clock me-1"></i> En cours
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ now()->diffInDays($emprunt->date_retour_prevue) }} jour(s) restant(s)
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('emprunts.show', $emprunt) }}" class="btn btn-sm btn-info"
                                                data-bs-toggle="tooltip" title="Voir détails">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('emprunts.edit', $emprunt) }}" class="btn btn-sm btn-warning"
                                                data-bs-toggle="tooltip" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                           

                                            <form action="{{ route('emprunts.destroy', $emprunt) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip" title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox display-1 text-muted"></i>
                                        <h5 class="text-muted">Aucun emprunt trouvé</h5>
                                        <a href="{{ route('emprunts.create') }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle me-1"></i> Créer le premier emprunt
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($emprunts->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Affichage de {{ $emprunts->firstItem() }} à {{ $emprunts->lastItem() }} sur
                            {{ $emprunts->total() }} résultats
                        </div>
                        <div>
                            {{ $emprunts->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .stat-card {
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>

    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endsection
