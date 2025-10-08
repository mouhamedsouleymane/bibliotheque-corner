@extends('layouts.app')

@section('title', 'Détails du livre')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Détails du livre</h1>
            <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informations générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Titre:</div>
                            <div class="col-md-8">{{ $livre->titre }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">ISBN:</div>
                            <div class="col-md-8">{{ $livre->isbn }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Auteur:</div>
                            <div class="col-md-8">{{ $livre->auteur->nom }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Catégorie:</div>
                            <div class="col-md-8">{{ $livre->categorie->nom }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Année de publication:</div>
                            <div class="col-md-8">{{ $livre->annee_publication }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Éditeur:</div>
                            <div class="col-md-8">{{ $livre->editeur }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Exemplaires:</div>
                            <div class="col-md-8">
                                {{ $livre->exemplaires_disponibles }} / {{ $livre->exemplaires_total }} disponibles
                                @if ($livre->exemplaires_disponibles == 0)
                                    <span class="badge bg-danger ms-2">Indisponible</span>
                                @else
                                    <span class="badge bg-success ms-2">Disponible</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 fw-bold">Description:</div>
                            <div class="col-md-8">{{ $livre->description ?? 'Aucune description disponible' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('livres.edit', $livre) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>Modifier le livre
                            </a>
                            <form action="{{ route('livres.destroy', $livre) }}" method="POST" class="d-grid">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre?')">
                                    <i class="bi bi-trash me-1"></i>Supprimer le livre
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($livre->image_couverture)
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Couverture</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/' . $livre->image_couverture) }}" alt="Couverture du livre"
                                class="img-fluid rounded" style="max-height: 300px;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .badge {
            font-size: 0.75rem;
        }
    </style>
@endsection
