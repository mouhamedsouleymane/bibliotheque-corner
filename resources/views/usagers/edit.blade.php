@extends('layouts.app')

@section('title', 'Modifier l\'usager')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-pencil-square me-2"></i>Modifier l'usager
                        </h2>
                        <a href="{{ route('usagers.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('usagers.update', $usager) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nom" class="form-label fw-bold">Nom <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nom" id="nom"
                                            value="{{ old('nom', $usager->nom) }}"
                                            class="form-control @error('nom') is-invalid @enderror" required>
                                        @error('nom')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prenom" class="form-label fw-bold">Prénom <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="prenom" id="prenom"
                                            value="{{ old('prenom', $usager->prenom) }}"
                                            class="form-control @error('prenom') is-invalid @enderror" required>
                                        @error('prenom')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_naissance" class="form-label fw-bold">Date de naissance <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="date_naissance" id="date_naissance"
                                            value="{{ old('date_naissance', \Carbon\Carbon::parse($usager->date_naissance)->format('Y-m-d')) }}"
                                            class="form-control @error('date_naissance') is-invalid @enderror" required>
                                        @error('date_naissance')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lieu_naissance" class="form-label fw-bold">Lieu de naissance <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="lieu_naissance" id="lieu_naissance"
                                            value="{{ old('lieu_naissance', $usager->lieu_naissance) }}"
                                            class="form-control @error('lieu_naissance') is-invalid @enderror" required>
                                        @error('lieu_naissance')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profession" class="form-label fw-bold">Profession <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="profession" id="profession"
                                            value="{{ old('profession', $usager->profession) }}"
                                            class="form-control @error('profession') is-invalid @enderror" required>
                                        @error('profession')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="identifiant" class="form-label fw-bold">Identifiant <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="identifiant" id="identifiant"
                                            value="{{ old('identifiant', $usager->identifiant) }}"
                                            class="form-control @error('identifiant') is-invalid @enderror" required>
                                        @error('identifiant')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="adresse" class="form-label fw-bold">Adresse <span
                                        class="text-danger">*</span></label>
                                <textarea name="adresse" id="adresse" rows="3" class="form-control @error('adresse') is-invalid @enderror"
                                    required>{{ old('adresse', $usager->adresse) }}</textarea>
                                @error('adresse')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telephone" class="form-label fw-bold">Téléphone <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="telephone" id="telephone"
                                            value="{{ old('telephone', $usager->telephone) }}"
                                            class="form-control @error('telephone') is-invalid @enderror" required>
                                        @error('telephone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quartier" class="form-label fw-bold">Quartier <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="quartier" id="quartier"
                                            value="{{ old('quartier', $usager->quartier) }}"
                                            class="form-control @error('quartier') is-invalid @enderror" required>
                                        @error('quartier')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('usagers.show', $usager) }}" class="btn btn-outline-secondary me-md-2">
                                    <i class="bi bi-eye me-1"></i> Voir détails
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                                </button>
                            </div>
                        </form>
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
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-1px);
        }

        .btn-outline-secondary:hover {
            transform: translateY(-1px);
        }

        .form-control-plaintext {
            padding: 0.375rem 0;
            margin-bottom: 0;
            line-height: 1.5;
            background-color: transparent;
            border: solid transparent;
            border-width: 1px 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-header .btn {
                margin-top: 10px;
                align-self: flex-end;
            }

            .row {
                flex-direction: column;
            }

            .col-md-6 {
                width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
