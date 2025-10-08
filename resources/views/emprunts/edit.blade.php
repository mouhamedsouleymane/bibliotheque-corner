@extends('layouts.app')

@section('title', 'Modifier l\'emprunt')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h4 mb-0">
                                <i class="bi bi-pencil-square me-2"></i>Modifier l'emprunt #{{ $emprunt->id }}
                            </h2>
                            <a href="{{ route('emprunts.show', $emprunt) }}" class="btn btn-dark btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Retour aux détails
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('emprunts.update', $emprunt) }}" method="POST" id="editForm">
                            @csrf
                            @method('PUT')

                            <!-- Informations non modifiables -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="bi bi-book me-2"></i>Livre</h6>
                                            <p class="card-text fw-bold text-primary mb-1">
                                                {{ $emprunt->livre->titre ?? 'Livre inconnu' }}</p>
                                            <small class="text-muted">ISBN: {{ $emprunt->livre->isbn ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="bi bi-person me-2"></i>Usager</h6>
                                            <p class="card-text fw-bold text-primary mb-1">
                                                {{ $emprunt->usager->nom ?? 'Usager inconnu' }}</p>
                                            <small class="text-muted">ID: {{ $emprunt->usager->id ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates modifiables -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date_emprunt" class="form-label fw-bold">Date d'emprunt <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="date_emprunt" id="date_emprunt"
                                            class="form-control @error('date_emprunt') is-invalid @enderror"
                                            value="{{ old('date_emprunt', $emprunt->date_emprunt->format('Y-m-d')) }}"
                                            required>
                                        @error('date_emprunt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date_retour_prevue" class="form-label fw-bold">Date de retour prévue
                                            <span class="text-danger">*</span></label>
                                        <input type="date" name="date_retour_prevue" id="date_retour_prevue"
                                            class="form-control @error('date_retour_prevue') is-invalid @enderror"
                                            value="{{ old('date_retour_prevue', $emprunt->date_retour_prevue->format('Y-m-d')) }}"
                                            required>
                                        @error('date_retour_prevue')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date_retour_effective" class="form-label fw-bold">Date de retour
                                            effective</label>
                                        <input type="date" name="date_retour_effective" id="date_retour_effective"
                                            class="form-control @error('date_retour_effective') is-invalid @enderror"
                                            value="{{ old('date_retour_effective', $emprunt->date_retour_effective ? $emprunt->date_retour_effective->format('Y-m-d') : '') }}">
                                        @error('date_retour_effective')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if (!$emprunt->date_retour_effective)
                                                <span class="text-warning">Laissez vide si le livre n'est pas encore
                                                    retourné</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-bold">Notes</label>
                                <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Notes supplémentaires sur cet emprunt...">{{ old('notes', $emprunt->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut actuel -->
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-3 h4 mb-0"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Statut actuel de l'emprunt</h6>
                                        @if ($emprunt->date_retour_effective)
                                            <span class="badge bg-success me-2">Retourné</span>
                                            Le {{ $emprunt->date_retour_effective->format('d/m/Y') }}
                                        @elseif($emprunt->date_retour_prevue->isPast())
                                            <span class="badge bg-danger me-2">En retard</span>
                                            {{ $emprunt->date_retour_prevue->diffInDays(now()) }} jour(s) de retard
                                        @else
                                            <span class="badge bg-primary me-2">En cours</span>
                                            {{ now()->diffInDays($emprunt->date_retour_prevue) }} jour(s) restant(s)
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('emprunts.show', $emprunt) }}" class="btn btn-outline-secondary me-md-2">
                                    <i class="bi bi-x-circle me-1"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Actions supplémentaires -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Actions rapides</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            

                            <a href="{{ route('emprunts.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Créer un nouvel emprunt
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateEmprunt = document.getElementById('date_emprunt');
            const dateRetourPrevue = document.getElementById('date_retour_prevue');
            const dateRetourEffective = document.getElementById('date_retour_effective');
            const form = document.getElementById('editForm');

            // Validation des dates
            function validateDates() {
                const emp = new Date(dateEmprunt.value);
                const prevue = new Date(dateRetourPrevue.value);
                const effective = dateRetourEffective.value ? new Date(dateRetourEffective.value) : null;

                // Date retour prévue doit être après date emprunt
                if (prevue <= emp) {
                    dateRetourPrevue.setCustomValidity(
                        'La date de retour prévue doit être après la date d\'emprunt');
                    return false;
                } else {
                    dateRetourPrevue.setCustomValidity('');
                }

                // Date retour effective doit être après date emprunt
                if (effective && effective < emp) {
                    dateRetourEffective.setCustomValidity(
                        'La date de retour effective ne peut pas être avant la date d\'emprunt');
                    return false;
                } else {
                    dateRetourEffective.setCustomValidity('');
                }

                return true;
            }

            // Événements de validation
            dateEmprunt.addEventListener('change', validateDates);
            dateRetourPrevue.addEventListener('change', validateDates);
            dateRetourEffective.addEventListener('change', validateDates);

            // Validation du formulaire
            form.addEventListener('submit', function(e) {
                if (!validateDates()) {
                    e.preventDefault();
                    alert('Veuillez corriger les erreurs dans les dates avant de soumettre le formulaire.');
                }
            });

            // Initialisation
            validateDates();
        });
    </script>

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .form-label {
            color: #4e73df;
        }

        .btn {
            border-radius: 0.35rem;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }
    </style>
@endsection
