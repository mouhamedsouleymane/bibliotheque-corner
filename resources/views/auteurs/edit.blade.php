@extends('layouts.app')

@section('title', 'Modifier l\'auteur')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0 font-weight-bold text-primary">Modifier l'auteur</h2>
                        <a href="{{ route('auteurs.show', $auteur) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour aux détails
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('auteurs.update', $auteur) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nom" class="form-label fw-bold">Nom *</label>
                                        <input type="text" name="nom" id="nom"
                                            value="{{ old('nom', $auteur->nom) }}"
                                            class="form-control @error('nom') is-invalid @enderror"
                                            placeholder="Entrez le nom de l'auteur" required>
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="bio" class="form-label fw-bold">Biographie</label>
                                        <textarea name="bio" id="bio" rows="6" class="form-control @error('bio') is-invalid @enderror"
                                            placeholder="Entrez la biographie de l'auteur">{{ old('bio', $auteur->bio) }}</textarea>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 d-flex justify-content-end gap-2">
                                    <a href="{{ route('auteurs.show', $auteur) }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>
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
    </style>
@endsection
