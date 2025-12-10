@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="id_inscription_admin" class="form-label">Étudiant (Inscription Annuelle)</label>
        <select id="id_inscription_admin" name="id_inscription_admin" class="form-select @error('id_inscription_admin') is-invalid @enderror" required>
            <option value="">Sélectionnez un étudiant</option>
            @foreach($inscriptions as $inscription)
                @if($inscription->etudiant)
                    <option value="{{ $inscription->id }}" data-parcours-id="{{ $inscription->id_parcours }}" @selected(old('id_inscription_admin', $paiement->id_inscription_admin ?? '') == $inscription->id)>
                        {{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }} ({{ $inscription->annee_academique }})
                    </option>
                @endif
            @endforeach
        </select>
        @error('id_inscription_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="montant" class="form-label">Montant (FCFA)</label>
        <input type="number" step="0.01" id="montant" name="montant" class="form-control @error('montant') is-invalid @enderror" value="{{ old('montant', $paiement->montant ?? '') }}" required min="0.01">
        @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="type_frais" class="form-label">Type de frais</label>
        <select id="type_frais" name="type_frais" class="form-select @error('type_frais') is-invalid @enderror" required>
            <option value="">Sélectionnez un type</option>
            @foreach($typesFrais as $type)
            <option value="{{ $type }}" @selected(old('type_frais', $paiement->type_frais ?? '') == $type)>
                {{ $type }}
            </option>
            @endforeach
        </select>
        @error('type_frais') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3" id="mois-concerne-wrapper" style="display: none;">
        <label for="mois_concerne" class="form-label">Mois Concerné</label>
        <select id="mois_concerne" name="mois_concerne" class="form-select">
            <option value="">Sélectionnez un mois</option>
            @foreach(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $mois)
                <option value="{{ $mois }}" @selected(old('mois_concerne', $paiement->mois_concerne ?? '') == $mois)>{{ $mois }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="methode_paiement" class="form-label">Méthode de paiement</label>
        <select id="methode_paiement" name="methode_paiement" class="form-select @error('methode_paiement') is-invalid @enderror" required>
            <option value="">Sélectionnez une méthode</option>
            @foreach($methodesPaiement as $methode)
            <option value="{{ $methode }}" @selected(old('methode_paiement', $paiement->methode_paiement ?? '') == $methode)>
                {{ $methode }}
            </option>
            @endforeach
        </select>
        @error('methode_paiement') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="date_paiement" class="form-label">Date du paiement</label>
        <input type="date" id="date_paiement" name="date_paiement" class="form-control @error('date_paiement') is-invalid @enderror" value="{{ old('date_paiement', isset($paiement) ? \Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
        @error('date_paiement') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @if(isset($paiement))
    <div class="col-md-6 mb-3">
        <label for="statut_paiement" class="form-label">Statut du paiement</label>
        <select id="statut_paiement" name="statut_paiement" class="form-select @error('statut_paiement') is-invalid @enderror" required>
            @foreach($statutsPaiement as $statut)
            <option value="{{ $statut }}" @selected(old('statut_paiement', $paiement->statut_paiement ?? '') == $statut)>
                {{ $statut }}
            </option>
            @endforeach
        </select>
        @error('statut_paiement') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @endif
</div>

<button type="submit" class="btn btn-primary">{{ isset($paiement) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('paiements.index') }}" class="btn btn-label-secondary">Annuler</a>

@section('footer')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fraisParcours = @json($fraisParcours);
    const inscriptionSelect = document.getElementById('id_inscription_admin');
    const typeFraisSelect = document.getElementById('type_frais');
    const montantInput = document.getElementById('montant');
    const moisWrapper = document.getElementById('mois-concerne-wrapper');

    function updateForm() {
        const selectedType = typeFraisSelect.value;
        const selectedInscriptionId = inscriptionSelect.value;
        
        montantInput.readOnly = false;
        moisWrapper.style.display = 'none';

        if (selectedInscriptionId && selectedType === 'Inscription') {
            const frais = fraisParcours[selectedInscriptionId] || 0;
            montantInput.value = frais;
            montantInput.readOnly = true;
        } else if (selectedType === 'Scolarité') {
            moisWrapper.style.display = 'block';
        } else if (selectedType !== 'Inscription') {
            montantInput.value = '';
        }
    }

    inscriptionSelect.addEventListener('change', updateForm);
    typeFraisSelect.addEventListener('change', updateForm);

    // Initial call in case of old input
    updateForm();
});
</script>
@endsection
