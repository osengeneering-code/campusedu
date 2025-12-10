@extends('layouts.admin')

@section('titre', 'Saisie des Notes')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Saisie des Notes pour l'évaluation: "{{ $evaluation->libelle }}" (Module: {{ $evaluation->module->libelle ?? 'N/A' }})</h5>
        <small class="text-muted">Barème: {{ $evaluation->evaluationType->max_score ?? '20' }}</small>
    </div>
    <div class="card-body">
        <form action="{{ route('gestion-cours.evaluations.notes.store', $evaluation) }}" method="POST">
            @csrf
            @method('PUT') {{-- Using PUT method for update --}}

            @if($etudiantsInscrits->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Note (sur {{ $evaluation->evaluationType->max_score ?? '20' }})</th>
                            <th>Appréciation</th>
                            <th>Absent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiantsInscrits as $inscription)
                            <tr>
                                <td>
                                    <strong>{{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }}</strong>
                                    <input type="hidden" name="notes[{{ $loop->index }}][id_inscription_admin]" value="{{ $inscription->id }}">
                                </td>
                                <td>
                                    <input type="number" 
                                           name="notes[{{ $loop->index }}][note_obtenue]" 
                                           class="form-control @error('notes.' . $loop->index . '.note_obtenue') is-invalid @enderror" 
                                           min="0" 
                                           max="{{ $evaluation->evaluationType->max_score ?? '20' }}" 
                                           step="0.01"
                                           value="{{ old('notes.' . $loop->index . '.note_obtenue', $notesExistantes[$inscription->id] ?? '') }}"
                                           {{ ($absentsExistants[$inscription->id] ?? false) ? 'disabled' : '' }}>
                                    @error('notes.' . $loop->index . '.note_obtenue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" 
                                           name="notes[{{ $loop->index }}][appreciation]" 
                                           class="form-control @error('notes.' . $loop->index . '.appreciation') is-invalid @enderror" 
                                           value="{{ old('notes.' . $loop->index . '.appreciation', $notesAppreciationsExistantes[$inscription->id] ?? '') }}"
                                           {{ ($absentsExistants[$inscription->id] ?? false) ? 'disabled' : '' }}>
                                    @error('notes.' . $loop->index . '.appreciation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               id="absentSwitch{{ $inscription->id }}" 
                                               name="notes[{{ $loop->index }}][est_absent]" 
                                               value="1" 
                                               {{ old('notes.' . $loop->index . '.est_absent', $absentsExistants[$inscription->id] ?? false) ? 'checked' : '' }}
                                               onchange="toggleNoteInput(this, 'notes[{{ $loop->index }}][note_obtenue]', 'notes[{{ $loop->index }}][appreciation]')">
                                        <label class="form-check-label" for="absentSwitch{{ $inscription->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Enregistrer les notes</button>
            @else
                <div class="alert alert-info" role="alert">
                    Aucun étudiant inscrit à ce module pour l'année académique "{{ $evaluation->annee_academique }}".
                </div>
            @endif
            <a href="{{ route('gestion-cours.evaluations.index') }}" class="btn btn-label-secondary mt-3 ms-2">Retour</a>
        </form>
    </div>
</div>
@endsection

@section('footer')
@parent
<script>
function toggleNoteInput(checkbox, noteInputName, appreciationInputName) {
    const noteInput = document.querySelector(`input[name="${noteInputName}"]`);
    const appreciationInput = document.querySelector(`input[name="${appreciationInputName}"]`);
    if (checkbox.checked) {
        noteInput.value = '';
        noteInput.disabled = true;
        appreciationInput.value = '';
        appreciationInput.disabled = true;
    } else {
        noteInput.disabled = false;
        appreciationInput.disabled = false;
    }
}

// Initial state for pre-filled forms
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-check-input[name$="[est_absent]"]').forEach(checkbox => {
        const index = checkbox.name.match(/\[(\d+)\]/)[1];
        toggleNoteInput(checkbox, `notes[${index}][note_obtenue]`, `notes[${index}][appreciation]`);
    });
});
</script>
@endsection