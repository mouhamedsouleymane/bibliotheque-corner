@extends('layouts.app')

@section('title', 'Gestion des auteurs')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Gestion des auteurs</h1>
            <a href="{{ route('auteurs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter un auteur
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Liste des auteurs</h6>
                <div class="d-flex">
                    <input type="text" id="searchInput" class="form-control form-control-sm me-2"
                        placeholder="Rechercher...">
                    <button class="btn btn-sm btn-outline-secondary" id="clearSearch">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Nombre de livres</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($auteurs as $auteur)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                {{ substr($auteur->nom, 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $auteur->nom }}</h6>
                                                <small class="text-muted">ID: {{ $auteur->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">{{ $auteur->livres_count }}
                                            livres</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('auteurs.show', $auteur) }}" class="btn btn-info btn-sm"
                                                data-bs-toggle="tooltip" title="Voir détails">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('auteurs.edit', $auteur) }}" class="btn btn-warning btn-sm"
                                                data-bs-toggle="tooltip" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('auteurs.destroy', $auteur) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip" title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur?')">
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

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Affichage de {{ $auteurs->firstItem() }} à {{ $auteurs->lastItem() }} sur {{ $auteurs->total() }}
                        auteurs
                    </div>
                    <div>
                        {{ $auteurs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-weight: bold;
        }

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

        .btn-group .btn {
            border-radius: 0.25rem;
            margin-right: 0.25rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        #searchInput {
            max-width: 200px;
        }
    </style>

    <script>
        // Fonctionnalité de recherche simple
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const rowText = rows[i].textContent.toLowerCase();
                    if (rowText.indexOf(searchText) === -1) {
                        rows[i].style.display = 'none';
                    } else {
                        rows[i].style.display = '';
                    }
                }
            });

            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                for (let i = 0; i < rows.length; i++) {
                    rows[i].style.display = '';
                }
            });

            // Initialiser les tooltips Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
