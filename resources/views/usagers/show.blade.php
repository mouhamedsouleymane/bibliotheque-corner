@extends('layouts.app')

@section('title', 'Détails de l\'usager')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-person-check me-2"></i>Détails de l'usager
                        </h2>
                        <a href="{{ route('usagers.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="m-0 font-weight-bold">
                                            <i class="bi bi-person me-2"></i>Informations personnelles
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 80px; height: 80px;">
                                                <span class="text-white fw-bold" style="font-size: 1.5rem;">
                                                    {{ substr($usager->prenom, 0, 1) }}{{ substr($usager->nom, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">{{ $usager->prenom }} {{ $usager->nom }}</h5>
                                                <p class="text-muted mb-1">Identifiant: {{ $usager->identifiant }}</p>
                                                <p class="mb-0">
                                                    <span class="badge bg-info">
                                                        {{ $usager->profession }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <small class="text-muted">Date de naissance:</small>
                                                <h6 class="mb-0">
                                                    {{ \Carbon\Carbon::parse($usager->date_naissance)->format('d/m/Y') }}
                                                </h6>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Lieu de naissance:</small>
                                                <h6 class="mb-0">
                                                    {{ $usager->lieu_naissance }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h5 class="m-0 font-weight-bold">
                                            <i class="bi bi-geo me-2"></i>Informations de contact
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Adresse</label>
                                            <p class="form-control-plaintext">
                                                <i class="bi bi-geo-alt me-1"></i> {{ $usager->adresse }}
                                            </p>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Téléphone</label>
                                                <p class="form-control-plaintext">
                                                    <i class="bi bi-telephone me-1"></i> {{ $usager->telephone }}
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Quartier</label>
                                                <p class="form-control-plaintext">
                                                    <i class="bi bi-pin-map me-1"></i> {{ $usager->quartier }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Date d'inscription</label>
                                            <p class="form-control-plaintext">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $usager->created_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('usagers.edit', $usager) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i> Modifier
                            </a>
                            <form action="{{ route('usagers.destroy', $usager) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet usager?')">
                                    <i class="bi bi-trash me-1"></i> Supprimer
                                </button>
                            </form>
                            <a href="{{ route('usagers.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-list me-1"></i> Liste des usagers
                            </a>
                        </div>
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
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .badge {
            font-size: 0.75rem;
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .form-control-plaintext {
            padding: 0.375rem 0;
            margin-bottom: 0;
            line-height: 1.5;
            background-color: transparent;
            border: solid transparent;
            border-width: 1px 0;
        }
    </style>
@endsection
