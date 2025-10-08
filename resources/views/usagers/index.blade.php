@extends('layouts.app')

@section('title', 'Gestion des usagers')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0 text-gray-800">
                <i class="bi bi-people me-2"></i>Gestion des usagers
            </h1>
            <a href="{{ route('usagers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nouvel usager
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom complet</th>
                                <th>Identifiant</th>
                                <th>Date de naissance</th>
                                <th>Profession</th>
                                <th>Téléphone</th>
                                <th>Quartier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usagers as $usager)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">
                                                        {{ substr($usager->prenom, 0, 1) }}{{ substr($usager->nom, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $usager->prenom }} {{ $usager->nom }}</h6>
                                                
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $usager->identifiant }}</td>
                                    <td>{{ \Carbon\Carbon::parse($usager->date_naissance)->format('d/m/Y') }}</td>
                                    <td>{{ $usager->profession }}</td>
                                    <td>{{ $usager->telephone }}</td>
                                    <td>{{ $usager->quartier }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('usagers.show', $usager) }}" class="btn btn-info btn-sm"
                                                data-bs-toggle="tooltip" title="Voir détails">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('usagers.edit', $usager) }}" class="btn btn-primary btn-sm"
                                                data-bs-toggle="tooltip" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('usagers.destroy', $usager) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip" title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet usager?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Affichage de {{ $usagers->firstItem() }} à {{ $usagers->lastItem() }}
                        sur {{ $usagers->total() }} résultats
                    </div>
                    <nav>
                        {{ $usagers->links() }}
                    </nav>
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

        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        #dataTable {
            font-size: 0.9rem;
        }
    </style>

    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
