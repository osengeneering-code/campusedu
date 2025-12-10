@extends('layouts.admin')

@section('titre', 'Mon Stage')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mon Espace /</span> Mon Stage</h4>

    @if($stage)
        <div class="row">
            <!-- Tutor Information -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Mon Tuteur de Stage</h5>
                    <div class="card-body">
                        @if($stage->enseignant)
                            <p><strong>Nom:</strong> {{ $stage->enseignant->prenom }} {{ $stage->enseignant->nom }}</p>
                            <p><strong>Email:</strong> {{ $stage->enseignant->email_pro }}</p>
                            <p><strong>Téléphone:</strong> {{ $stage->enseignant->telephone_pro }}</p>
                        @else
                            <p>Aucun tuteur n'a été assigné pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Report Submission and Status -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Mon Rapport de Stage</h5>
                    <div class="card-body">
                        <p><strong>Statut du rapport:</strong> <span class="badge bg-label-primary">{{ ucfirst($stage->statut_rapport) }}</span></p>

                        @if($stage->rapport_path)
                            <p><a href="{{ Storage::url($stage->rapport_path) }}" target="_blank">Télécharger mon rapport soumis</a></p>
                        @endif

                        <form action="{{ route('etudiant.stage.submit_report', $stage) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="rapport" class="form-label">Soumettre/Mettre à jour mon rapport (PDF)</label>
                                <input class="form-control" type="file" id="rapport" name="rapport" accept=".pdf">
                            </div>
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback from Tutor -->
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Feedback du Tuteur</h5>
                <div class="card-body">
                    @if($stage->feedback)
                        <div>{!! nl2br(e($stage->feedback)) !!}</div>
                    @else
                        <p>Aucun feedback pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Vous n'avez aucun stage enregistré pour le moment.
        </div>
    @endif
</div>
@endsection
