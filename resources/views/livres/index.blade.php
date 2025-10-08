@extends('layouts.app')

@section('title', 'Gestion des livres')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Gestion des livres</h1>
            <a href="{{ route('livres.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Ajouter un livre
            </a>
        </div>

        <!-- Formulaire de recherche -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('livres.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="form-control" placeholder="Titre, ISBN, auteur...">
                        </div>
                        <div class="col-md-4">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select name="categorie" id="categorie" class="form-select">
                                <option value="">Toutes les catégories</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}"
                                        {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-funnel me-1"></i>Filtrer
                            </button>
                            <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i>Réinitialiser
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des livres -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Disponibilité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($livres as $livre)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $livre->titre }}</div>
                                        <small class="text-muted">ISBN: {{ $livre->isbn }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $livre->auteur->nom }}</div>
                                        <small class="text-muted">{{ $livre->categorie->nom }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $livre->exemplaires_disponibles }} / {{ $livre->exemplaires_total }}
                                            disponibles</div>
                                        @if ($livre->exemplaires_disponibles == 0)
                                            <span class="badge bg-danger">Indisponible</span>
                                        @else
                                            <span class="badge bg-success">Disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('livres.show', $livre) }}" class="btn btn-info btn-sm"
                                                title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('livres.edit', $livre) }}" class="btn btn-warning btn-sm"
                                                title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('livres.destroy', $livre) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre?')"
                                                    title="Supprimer">
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

                <div class="d-flex justify-content-center mt-4">
                    {{ $livres->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        .table th {
            border-top: none;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .btn-group .btn {
            border-radius: 0.25rem;
            margin-right: 0.25rem;
        }

        .badge {
            font-size: 0.75rem;
        }
    </style>
@endsection
