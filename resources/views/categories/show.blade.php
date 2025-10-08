@extends('layouts.app')

@section('title', 'Détails de la catégorie')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0 font-weight-bold text-primary">Détails de la catégorie</h2>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="m-0 font-weight-bold">Informations</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Nom</label>
                                            <p class="form-control-plaintext">{{ $categorie->nom }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Description</label>
                                            <p class="form-control-plaintext">
                                                {{ $categorie->description ?? 'Aucune description disponible' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Nombre de livres</label>
                                            <p>
                                                <span class="badge bg-primary rounded-pill fs-6">
                                                    {{ $categorie->livres_count }} livre(s)
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="m-0 font-weight-bold">Livres dans cette catégorie</h5>
                                        <span class="badge bg-primary">{{ $categorie->livres_count }}</span>
                                    </div>
                                    <div class="card-body">
                                        @if ($categorie->livres->count() > 0)
                                            <div class="list-group list-group-flush">
                                                @foreach ($categorie->livres as $livre)
                                                    <a href="{{ route('livres.show', $livre) }}"
                                                        class="list-group-item list-group-item-action">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h6 class="mb-1">{{ $livre->titre }}</h6>
                                                            <small
                                                                class="text-muted">{{ $livre->annee_publication }}</small>
                                                        </div>
                                                        <p class="mb-1 text-muted">par {{ $livre->auteur->nom }}</p>
                                                        <small class="text-muted">
                                                            ISBN: {{ $livre->isbn }} |
                                                            Exemplaires:
                                                            {{ $livre->exemplaires_disponibles }}/{{ $livre->exemplaires_total }}
                                                        </small>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4 text-muted">
                                                <i class="bi bi-book fs-1"></i>
                                                <p class="mt-2">Aucun livre dans cette catégorie</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('categories.edit', $categorie) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('categories.destroy', $categorie) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            border-bottom: 1px solid #e3e6f0;
        }

        .bg-light {
            background-color: #f8f9fc !important;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #e3e6f0;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .form-control-plaintext {
            padding: 0.375rem 0;
            margin-bottom: 0;
            line-height: 1.5;
            background-color: transparent;
            border: solid transparent;
            border-width: 1px 0;
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .badge {
            font-size: 0.85em;
        }
    </style>
@endsection
