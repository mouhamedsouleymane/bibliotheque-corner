@extends('layouts.app')

@section('title', 'Détails de l\'auteur')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0 font-weight-bold text-primary">Détails de l'auteur</h2>
                        <a href="{{ route('auteurs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h4 class="text-primary">{{ $auteur->nom }}</h4>
                                    <p class="text-muted">ID: {{ $auteur->id }}</p>
                                </div>

                                <div class="mb-4">
                                    <h5 class="text-dark">Biographie</h5>
                                    <div class="bg-light p-3 rounded">
                                        @if ($auteur->bio)
                                            {{ $auteur->bio }}
                                        @else
                                            <span class="text-muted">Aucune biographie disponible</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <a href="{{ route('auteurs.edit', $auteur) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('auteurs.destroy', $auteur) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center">
                                        <div
                                            class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            {{ substr($auteur->nom, 0, 1) }}
                                        </div>
                                        <h5 class="card-title">Statistiques</h5>
                                        <div class="d-flex justify-content-around mt-4">
                                            <div class="text-center">
                                                <h3 class="text-primary mb-0">{{ $auteur->livres_count }}</h3>
                                                <small class="text-muted">Livres</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-dark mb-3">Livres de cet auteur</h5>

                                @if ($auteur->livres->count() > 0)
                                    <div class="row">
                                        @foreach ($auteur->livres as $livre)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $livre->titre }}</h6>
                                                        <p class="card-text text-muted small">
                                                            {{ $livre->annee_publication }} • {{ $livre->categorie->nom }}
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span
                                                                class="badge bg-{{ $livre->exemplaires_disponibles > 0 ? 'success' : 'danger' }}">
                                                                {{ $livre->exemplaires_disponibles }} disponible(s)
                                                            </span>
                                                            <a href="{{ route('livres.show', $livre) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                Voir
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-book fs-1"></i>
                                        <p class="mt-2">Aucun livre attribué à cet auteur</p>
                                        <a href="{{ route('livres.create') }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle"></i> Ajouter un livre
                                        </a>
                                    </div>
                                @endif
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
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .avatar-lg {
            width: 80px;
            height: 80px;
            font-size: 2rem;
            font-weight: bold;
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .badge {
            font-size: 0.75rem;
        }
    </style>
@endsection
