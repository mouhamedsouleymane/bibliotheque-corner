@extends('layouts.app')

@section('title', 'Modifier la catégorie')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-tag me-2"></i>Modifier la catégorie
                        </h2>
                        <a href="{{ route('categories.show', $categorie) }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $categorie) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nom" class="form-label fw-bold">Nom de la catégorie *</label>
                                        <input type="text" name="nom" id="nom"
                                            value="{{ old('nom', $categorie->nom) }}"
                                            class="form-control @error('nom') is-invalid @enderror"
                                            placeholder="Entrez le nom de la catégorie" required>
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Le nom doit être unique et descriptif.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror" placeholder="Décrivez brièvement cette catégorie">{{ old('description', $categorie->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Cette description aidera à classer les
                                            livres.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 d-flex justify-content-end gap-2">
                                    <a href="{{ route('categories.show', $categorie) }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Section de statistiques -->
                <div class="card shadow mt-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-graph-up me-2"></i>Statistiques de la catégorie
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary">{{ $categorie->livres_count ?? 0 }}</h3>
                                    <p class="text-muted mb-0">Livres dans cette catégorie</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-success">
                                        {{ $categorie->livres()->where('exemplaires_disponibles', '>', 0)->count() }}</h3>
                                    <p class="text-muted mb-0">Livres disponibles</p>
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
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .border {
            border: 1px solid #e3e6f0 !important;
        }
    </style>
@endsection
