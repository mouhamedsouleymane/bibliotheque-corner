@extends('layouts.app')

@section('title', 'Détails de l\'emprunt')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h4 mb-0">
                                <i class="bi bi-eye me-2"></i>Détails de l'emprunt #{{ $emprunt->id }}
                            </h2>
                            <a href="{{ route('emprunts.index') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3"><i class="bi bi-book me-2"></i>Informations du livre</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="40%">Titre :</td>
                                        <td>{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">ISBN :</td>
                                        <td>{{ $emprunt->livre->isbn ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Auteur :</td>
                                        <td>{{ $emprunt->livre->auteur->nom ?? 'Non spécifié' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Catégorie :</td>
                                        <td>{{ $emprunt->livre->categorie->nom ?? 'Non spécifié' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Disponibilité :</td>
                                        <td>
                                            @if ($emprunt->livre)
                                                <span
                                                    class="badge bg-{{ $emprunt->livre->exemplaires_disponibles > 0 ? 'success' : 'danger' }}">
                                                    {{ $emprunt->livre->exemplaires_disponibles }} /
                                                    {{ $emprunt->livre->exemplaires_total }} disponibles
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3"><i class="bi bi-person me-2"></i>Informations de l'usager</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="40%">Nom :</td>
                                        <td>{{ $emprunt->usager->nom ?? 'Usager inconnu' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email :</td>
                                        <td>{{ $emprunt->usager->email ?? 'Non spécifié' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Téléphone :</td>
                                        <td>{{ $emprunt->usager->telephone ?? 'Non spécifié' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">ID :</td>
                                        <td>#{{ $emprunt->usager->id ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <h5 class="text-primary mb-3"><i class="bi bi-calendar me-2"></i>Dates importantes</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Date d'emprunt :</td>
                                        <td>
                                            <span
                                                class="badge bg-info">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Retour prévu :</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue->isPast()) && !$emprunt->date_retour_effective ? 'danger' : 'warning' }}">
                                                {{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Retour effectif :</td>
                                        <td>
                                            @if ($emprunt->date_retour_effective)
                                                <span
                                                    class="badge bg-success">{{ \Carbon\Carbon::parse($emprunt->date_retour_effective)->format('d/m/Y') }}</span>
                                            @else
                                                <span class="badge bg-secondary">En attente</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <h5 class="text-primary mb-3"><i class="bi bi-graph-up me-2"></i>Statistiques</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Durée d'emprunt :</td>
                                        <td>
                                            @if ($emprunt->date_retour_effective)
                                                {{ $emprunt->date_emprunt->diffInDays($emprunt->date_retour_effective) }}
                                                jours
                                            @else
                                                {{ $emprunt->date_emprunt->diffInDays(now()) }} jours (en cours)
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Retard :</td>
                                        <td>
                                            @if (!$emprunt->date_retour_effective && \Carbon\Carbon::parse($emprunt->date_retour_prevue->isPast()))
                                                <span class="text-danger fw-bold">
                                                    {{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s)
                                                </span>
                                            @else
                                                <span class="text-success">Aucun</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jours restants :</td>
                                        <td>
                                            @if (!$emprunt->date_retour_effective && !\Carbon\Carbon::parse($emprunt->date_retour_prevue->isPast()))
                                                <span class="text-primary fw-bold">
                                                    {{ now()->diffInDays($emprunt->date_retour_prevue) }} jour(s)
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <h5 class="text-primary mb-3"><i class="bi bi-tag me-2"></i>Statut</h5>
                                <div class="text-center">
                                    @if ($emprunt->date_retour_effective)
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle display-4"></i>
                                            <h5>Retourné</h5>
                                            <p class="mb-0">Le {{ \Carbon\Carbon::parse($emprunt->date_retour_effective)->format('d/m/Y') }}</p>
                                        </div>
                                    @elseif(\Carbon\Carbon::parse($emprunt->date_retour_prevue->isPast()))
                                        <div class="alert alert-danger">
                                            <i class="bi bi-exclamation-triangle display-4"></i>
                                            <h5>En retard</h5>
                                            <p class="mb-0">{{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s)
                                                de retard</p>
                                        </div>
                                    @else
                                        <div class="alert alert-primary">
                                            <i class="bi bi-clock display-4"></i>
                                            <h5>En cours</h5>
                                            <p class="mb-0">{{ now()->diffInDays($emprunt->date_retour_prevue) }} jour(s)
                                                restant(s)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($emprunt->notes)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3"><i class="bi bi-chat-text me-2"></i>Notes</h5>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $emprunt->notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Créé le {{ \Carbon\Carbon::parse($emprunt->created_at)->format('d/m/Y à H:i') }}
                                @if ($emprunt->created_at != $emprunt->updated_at)
                                    • Modifié le {{ \Carbon\Carbon::parse($emprunt->updated_at)->format('d/m/Y à H:i') }}
                                @endif
                            </small>
                            <div class="btn-group">
                                <a href="{{ route('emprunts.edit', $emprunt) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i> Modifier
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Actions rapides -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Actions rapides</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('emprunts.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Nouvel emprunt
                            </a>
                            <a href="{{ route('emprunts.edit', $emprunt) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i> Modifier cet emprunt
                            </a>
                            
                            <form action="{{ route('emprunts.destroy', $emprunt) }}" method="POST" class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt?')">
                                    <i class="bi bi-trash me-1"></i> Supprimer cet emprunt
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Historique des modifications -->
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historique</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-calendar-plus text-primary me-2"></i>
                                    <span>Emprunt créé</span>
                                </div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($emprunt->created_at)->format('d/m/Y H:i') }}</small>
                            </li>
                            @if ($emprunt->date_retour_effective)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <span>Livre retourné</span>
                                    </div>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($emprunt->date_retour_effective)->format('d/m/Y H:i') }}</small>
                                </li>
                            @endif
                            @if ($emprunt->created_at != $emprunt->updated_at)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-pencil text-warning me-2"></i>
                                        <span>Dernière modification</span>
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($emprunt->updated_at)->format('d/m/Y H:i') }}</small>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
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

        .table-borderless td {
            border: none;
            padding: 0.5rem;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        .btn {
            border-radius: 0.35rem;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection
