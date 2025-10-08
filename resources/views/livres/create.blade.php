@extends('layouts.app')

@section('title', 'Ajouter un livre')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Ajouter un nouveau livre</h1>
            <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('livres.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                                    class="form-control @error('isbn') is-invalid @enderror" required>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                                    class="form-control @error('titre') is-invalid @enderror" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="auteur_id" class="form-label">Auteur <span class="text-danger">*</span></label>
                                <select name="auteur_id" id="auteur_id"
                                    class="form-select @error('auteur_id') is-invalid @enderror" required>
                                    <option value="">Sélectionner un auteur</option>
                                    @foreach ($auteurs as $auteur)
                                        <option value="{{ $auteur->id }}"
                                            {{ old('auteur_id') == $auteur->id ? 'selected' : '' }}>
                                            {{ $auteur->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('auteur_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categorie_id" class="form-label">Catégorie <span
                                        class="text-danger">*</span></label>
                                <select name="categorie_id" id="categorie_id"
                                    class="form-select @error('categorie_id') is-invalid @enderror" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="annee_publication" class="form-label">Année de publication <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="annee_publication" id="annee_publication"
                                    value="{{ old('annee_publication') }}"
                                    class="form-control @error('annee_publication') is-invalid @enderror" required>
                                @error('annee_publication')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="exemplaires_total" class="form-label">Nombre d'exemplaires <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="exemplaires_total" id="exemplaires_total"
                                    value="{{ old('exemplaires_total', 1) }}" min="1"
                                    class="form-control @error('exemplaires_total') is-invalid @enderror" required>
                                @error('exemplaires_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editeur" class="form-label">Éditeur <span class="text-danger">*</span></label>
                                <input type="text" name="editeur" id="editeur" value="{{ old('editeur') }}"
                                    class="form-control @error('editeur') is-invalid @enderror" required>
                                @error('editeur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Ajouter le livre
                        </button>
                        <a href="{{ route('livres.index') }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
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

        .form-label {
            font-weight: 500;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
@endsection
