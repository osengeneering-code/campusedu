@extends('layouts.admin')

@section('titre', 'Détail Candidature')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Détails de la candidature de {{ $candidature->prenom }} {{ $candidature->nom }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Nom:</strong> {{ $candidature->nom }}</p>
        <p><strong>Prénom:</strong> {{ $candidature->prenom }}</p>
        <p><strong>Email:</strong> {{ $candidature->email }}</p>
        <p><strong>Filière Souhaitée:</strong> {{ $candidature->filiere->nom ?? 'N/A' }}</p>
        <p><strong>Date de Candidature:</strong> {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y H:i') }}</p>
        <p><strong>Statut:</strong> <span class="badge bg-label-info">{{ $candidature->statut }}</span></p>

        <h6>Dossier et Pièces Jointes</h6>
        @if($candidature->dossier_pieces_jointes)
            @php $documents = json_decode($candidature->dossier_pieces_jointes, true); @endphp
            @if(is_array($documents) && !empty($documents))
            <ul class="list-group mb-3">
                @foreach($documents as $docName => $docPath)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $docName }}</span>
                    <a href="{{ asset('storage/' . $docPath) }}" target="_blank" class="btn btn-sm btn-outline-primary">Voir</a>
                </li>
                @endforeach
            </ul>
            @else
            <p>Aucune pièce jointe.</p>
            @endif
        @else
        <p>Aucune pièce jointe.</p>
        @endif

        <div class="mt-4">
            {{-- Formulaire de validation/rejet de la candidature --}}
            @if ($candidature->statut == \App\Models\Candidature::STATUT_EN_ATTENTE)
            <form action="{{-- route('inscriptions.candidatures.valider', $candidature) --}}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-success">Valider la candidature</button>
            </form>
            <form action="{{-- route('inscriptions.candidatures.rejeter', $candidature) --}}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-danger">Rejeter la candidature</button>
            </form>
            @endif
            <a href="{{ route('inscriptions.candidatures.index') }}" class="btn btn-label-secondary">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
