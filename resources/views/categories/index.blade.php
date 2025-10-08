@extends('layouts.app')

@section('title', 'Gestion des catégories')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Gestion des catégories</h1>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter une catégorie
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Liste des catégories</h6>
                <div class="d-flex">
                    <input type="text" id="searchInput" class="form-control form-control-sm me-2"
                        placeholder="Rechercher...">
                    <button class="btn btn-sm btn-outline-secondary" id="clearSearch">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="sortable" data-sort="name">Nom <i class="bi bi-arrow-down"></i>
                                </th>
                                <th scope="col" class="sortable" data-sort="livres_count">Nombre de livres <i
                                        class="bi bi-arrow-down"></i></th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $categorie)
                                <tr>
                                    <td class="fw-bold">{{ $categorie->nom }}</td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">{{ $categorie->livres_count }}
                                            livres</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('categories.show', $categorie) }}" class="btn btn-info btn-sm"
                                                title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $categorie) }}"
                                                class="btn btn-warning btn-sm" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $categorie) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Affichage de {{ $categories->firstItem() }} à {{ $categories->lastItem() }} sur
                        {{ $categories->total() }} catégories
                    </div>
                    <nav>
                        {{ $categories->links('vendor.pagination.bootstrap-5') }}
                    </nav>
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

        .table th {
            border-top: none;
            font-weight: 600;
        }

        .sortable {
            cursor: pointer;
        }

        .sortable:hover {
            background-color: #f8f9fa;
        }

        .btn-group .btn {
            border-radius: 0.25rem;
            margin: 0 2px;
        }

        .badge {
            font-size: 0.85em;
        }

        #searchInput {
            width: 200px;
        }

        @media (max-width: 768px) {
            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .btn-group .btn {
                margin: 0;
            }

            #searchInput {
                width: 150px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Recherche en temps réel
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                    const count = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();

                    if (name.includes(searchText) || count.includes(searchText)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                for (let i = 0; i < rows.length; i++) {
                    rows[i].style.display = '';
                }
            });

            // Tri des colonnes
            const sortableHeaders = document.querySelectorAll('.sortable');

            sortableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.dataset.sort;
                    const isAscending = this.classList.contains('asc');

                    // Réinitialiser les autres en-têtes
                    sortableHeaders.forEach(h => {
                        h.classList.remove('asc', 'desc');
                        h.innerHTML = h.innerHTML.replace(
                            /<i class="bi bi-arrow-(down|up)"><\/i>/, '');
                    });

                    // Changer la direction de tri
                    if (isAscending) {
                        this.classList.remove('asc');
                        this.classList.add('desc');
                        this.innerHTML += ' <i class="bi bi-arrow-up"></i>';
                        sortTable(column, false);
                    } else {
                        this.classList.remove('desc');
                        this.classList.add('asc');
                        this.innerHTML += ' <i class="bi bi-arrow-down"></i>';
                        sortTable(column, true);
                    }
                });
            });

            function sortTable(column, ascending) {
                const tbody = table.getElementsByTagName('tbody')[0];
                const rows = Array.from(tbody.getElementsByTagName('tr'));

                rows.sort((a, b) => {
                    let aValue, bValue;

                    if (column === 'name') {
                        aValue = a.getElementsByTagName('td')[0].textContent.trim();
                        bValue = b.getElementsByTagName('td')[0].textContent.trim();
                    } else if (column === 'livres_count') {
                        aValue = parseInt(a.getElementsByTagName('td')[1].textContent);
                        bValue = parseInt(b.getElementsByTagName('td')[1].textContent);
                    }

                    if (ascending) {
                        return aValue > bValue ? 1 : -1;
                    } else {
                        return aValue < bValue ? 1 : -1;
                    }
                });

                // Vider et remplir le tableau
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }

                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }
        });
    </script>
@endsection
