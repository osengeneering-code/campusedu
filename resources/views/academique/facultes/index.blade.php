@extends('layouts.admin')

@section('titre', 'Liste des facultés')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Liste des facultés</h3>

            <div>
                <a href="{{ route('academique.facultes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter une faculté
                </a>
            </div>
        </div>

        <div class="card-body">

            {{-- Barre de recherche (optionnelle) --}}
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Rechercher une faculté..." value="{{ request('q') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($facultes as $faculte)
                            <tr>
                                <td>{{ $faculte->id }}</td>
                                <td>{{ $faculte->nom }}</td>
                                <td>{{ Str::limit($faculte->description, 80) }}</td>

                                <td class="text-center">
                                    <a href="{{ route('academique.facultes.show', $faculte->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('academique.facultes.edit', $faculte->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('academique.facultes.destroy', $faculte->id) }}" 
                                          method="POST" class="d-inline-block"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette faculté ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Aucune faculté trouvée.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination (si utilisée dans le contrôleur) --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $facultes->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
