@extends('layouts.app')

@section('title', 'Nouvel emprunt')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h4 mb-0">
                                <i class="bi bi-plus-circle me-2"></i>Nouvel emprunt
                            </h2>
                            <a href="{{ route('emprunts.index') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('emprunts.store') }}" method="POST" id="empruntForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="livre_id" class="form-label fw-bold">Livre <span
                                                class="text-danger">*</span></label>
                                        <select name="livre_id" id="livre_id"
                                            class="form-select @error('livre_id') is-invalid @enderror" required>
                                            <option value="">Sélectionner un livre</option>
                                            @foreach ($livres as $livre)
                                                <option value="{{ $livre->id }}"
                                                    {{ old('livre_id') == $livre->id ? 'selected' : '' }}
                                                    data-disponibles="{{ $livre->exemplaires_disponibles }}">
                                                    {{ $livre->titre }} ({{ $livre->exemplaires_disponibles }} disponibles)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('livre_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text" id="livreInfo"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="usager_id" class="form-label fw-bold">Usager <span
                                                class="text-danger">*</span></label>
                                        <select name="usager_id" id="usager_id"
                                            class="form-select @error('usager_id') is-invalid @enderror" required>
                                            <option value="">Sélectionner un usager</option>
                                            @foreach ($usagers as $usager)
                                                <option value="{{ $usager->id }}"
                                                    {{ old('usager_id') == $usager->id ? 'selected' : '' }}>
                                                    {{ $usager->nom }}
                                                    @if ($usager->email)
                                                        - {{ $usager->email }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('usager_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date_retour_prevue" class="form-label fw-bold">Date de retour prévue
                                            <span class="text-danger">*</span></label>
                                        <input type="date" name="date_retour_prevue" id="date_retour_prevue"
                                            class="form-control @error('date_retour_prevue') is-invalid @enderror"
                                            value="{{ old('date_retour_prevue') }}"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        @error('date_retour_prevue')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">La date doit être ultérieure à aujourd'hui</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Date d'emprunt</label>
                                        <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}"
                                            readonly>
                                        <div class="form-text">Date automatique (aujourd'hui)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-bold">Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Notes optionnelles sur cet emprunt...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="{{ route('emprunts.index') }}" class="btn btn-outline-secondary me-md-2">
                                    <i class="bi bi-x-circle me-1"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Enregistrer l'emprunt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Informations sur les disponibilités -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Livres disponibles :</strong> {{ $livres->count() }} livre(s) peuvent
                            être empruntés</p>
                        <p class="mb-2"><strong>Usagers :</strong> {{ $usagers->count() }} usager(s) peuvent emprunter
                        </p>
                        <p class="mb-0 text-muted"><small>Un usager ne peut pas emprunter le même livre plusieurs fois
                                simultanément.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const livreSelect = document.getElementById('livre_id');
            const livreInfo = document.getElementById('livreInfo');
            const dateRetourInput = document.getElementById('date_retour_prevue');

            // Mettre à jour les informations du livre sélectionné
            function updateLivreInfo() {
                const selectedOption = livreSelect.options[livreSelect.selectedIndex];
                const disponibles = selectedOption.getAttribute('data-disponibles');

                if (livreSelect.value && disponibles !== null) {
                    if (parseInt(disponibles) > 0) {
                        livreInfo.innerHTML = < span class = "text-success" > < i class = "bi bi-check-circle" > <
                            /i> ${disponibles} exemplaire(s) disponible(s)</span > ;
                    } else {
                        livreInfo.innerHTML = < span class = "text-danger" > < i class =
                            "bi bi-exclamation-triangle" > < /i> Aucun exemplaire disponible</span > ;
                    }
                } else {
                    livreInfo.innerHTML = '';
                }
            }

            // Définir la date minimale pour le retour (demain)
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            dateRetourInput.min = tomorrow.toISOString().split('T')[0];

            // Événements
            livreSelect.addEventListener('change', updateLivreInfo);

            // Initialiser
            updateLivreInfo();

            // Validation du formulaire
            document.getElementById('empruntForm').addEventListener('submit', function(e) {
                const selectedOption = livreSelect.options[livreSelect.selectedIndex];
                const disponibles = parseInt(selectedOption.getAttribute('data-disponibles'));

                if (livreSelect.value && disponibles <= 0) {
                    e.preventDefault();
                    alert(
                        'Ce livre n\'a plus d\'exemplaires disponibles. Veuillez en sélectionner un autre.'
                    );
                    return false;
                }
            });
        });
    </script>

    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .form-label {
            color: #4e73df;
        }

        .btn {
            border-radius: 0.35rem;
        }
    </style>
@endsection
