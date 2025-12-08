    <h4 class="py-3 mb-4">
        Saisie des Notes pour : {{ $evaluation->libelle }}
        <small class="text-muted">({{ $evaluation->module->nom }})</small>
    </h4>

    <form action="{{ route('gestion-cours.notes.store') }}" method="POST">
        @csrf
        <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">

        <div class="card">
            <h5 class="card-header">Liste des Étudiants Inscrits (sur {{ $evaluation->evaluationType->max_score ?? 20 }})</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom de l'étudiant</th>
                            <th>Note (/{{ $evaluation->evaluationType->max_score ?? 20 }})</th>
                            <th>Absent(e)</th>
                            <th>Appréciation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiantsInscrits as $inscription)
                            <tr>
                                <td>{{ $inscription->etudiant->nom_complet }}</td>
                                <td>
                                    <input type="number" step="0.25" min="0" max="{{ $evaluation->evaluationType->max_score ?? 20 }}" 
                                           name="notes[{{ $inscription->id }}][note]" 
                                           class="form-control"
                                           value="{{ old('notes.'.$inscription->id.'.note', optional($notesExistantes[$inscription->id] ?? null)->note_obtenue) }}"
                                           >
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="notes[{{ $inscription->id }}][absent]"
                                               @if(old('notes.'.$inscription->id.'.absent', optional($notesExistantes[$inscription->id] ?? null)->est_absent)) checked @endif
                                               >
                                    </div>
                                </td>
                                <td>
                                    <input type="text" 
                                           name="notes[{{ $inscription->id }}][appreciation]" 
                                           class="form-control"
                                           value="{{ old('notes.'.$inscription->id.'.appreciation', optional($notesExistantes[$inscription->id] ?? null)->appreciation) }}"
                                           >
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Aucun étudiant inscrit à ce module.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enregistrer les Notes</button>
            </div>
        </div>
    </form>
</div>
@endsection
