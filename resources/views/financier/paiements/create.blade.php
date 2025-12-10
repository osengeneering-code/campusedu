@extends('layouts.admin')

@section('titre', 'Enregistrer un Paiement')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Enregistrer un nouveau paiement</h5>
    </div>
    <div class="card-body">
        <div id="solde-info" class="alert alert-info" style="display: none;"></div>
        <form action="{{ route('paiements.store') }}" method="POST">
            @include('financier.paiements._form', ['paiement' => null])
        </form>
    </div>
</div>
@endsection

@section('footer')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fraisParcours = @json($fraisParcours ?? []);
    const soldesScolarite = @json($soldesScolarite ?? []);
    const inscriptionSelect = document.getElementById('id_inscription_admin');
    const typeFraisSelect = document.getElementById('type_frais');
    const montantInput = document.getElementById('montant');
    const moisWrapper = document.getElementById('mois-concerne-wrapper');
    const soldeInfoDiv = document.getElementById('solde-info');

    function formatCurrency(value) {
        return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(value);
    }

    function updateForm() {
        const selectedType = typeFraisSelect.value;
        const selectedInscriptionId = inscriptionSelect.value;
        
        montantInput.readOnly = false;
        moisWrapper.style.display = 'none';
        soldeInfoDiv.style.display = 'none';
        soldeInfoDiv.classList.remove('alert-success', 'alert-info');


        if (selectedInscriptionId) {
            const solde = soldesScolarite[selectedInscriptionId];
            if (typeof solde !== 'undefined') {
                if (solde <= 0) {
                    soldeInfoDiv.innerHTML = `<strong>Scolarité entièrement soldée</strong>`;
                    soldeInfoDiv.classList.add('alert-success');
                } else {
                    soldeInfoDiv.innerHTML = `<strong>Solde de scolarité restant pour cet étudiant : ${formatCurrency(solde)}</strong>`;
                    soldeInfoDiv.classList.add('alert-info');
                }
                soldeInfoDiv.style.display = 'block';
            }

            if (selectedType === 'Inscription') {
                const frais = fraisParcours[selectedInscriptionId] || 0;
                montantInput.value = frais;
                montantInput.readOnly = true;
            } else if (selectedType === 'Scolarité') {
                moisWrapper.style.display = 'block';
            }
        }
    }

    inscriptionSelect.addEventListener('change', updateForm);
    typeFraisSelect.addEventListener('change', updateForm);

    updateForm();
});
</script>
@endsection
