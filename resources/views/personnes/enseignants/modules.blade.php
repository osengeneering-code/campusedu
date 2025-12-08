@extends('layouts.admin')

@section('titre', 'Assigner des Modules')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Assigner des modules à : {{ $enseignant->nom }} {{ $enseignant->prenom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('personnes.enseignants.modules.store', $enseignant) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="module_ids">Modules</label>
                    <select name="module_ids[]" id="module_ids" class="form-select" multiple style="height: 300px;">
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" @selected(in_array($module->id, old('module_ids', $assignedModuleIds)))>
                                {{ $module->code_module }} - {{ $module->libelle }} ({{ $module->ue->semestre->parcours->nom ?? 'N/A' }} - {{ $module->ue->semestre->niveau ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('module_ids') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour les assignations</button>
            <a href="{{ route('personnes.enseignants.show', $enseignant) }}" class="btn btn-label-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
