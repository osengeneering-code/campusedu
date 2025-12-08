<!DOCTYPE html>
<html>
<head>
    <title>Profil Étudiant - {{ $etudiant->nom }} {{ $etudiant->prenom }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; line-height: 1.5; }
        .container { width: 100%; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; padding: 0; }
        .section-title { background-color: #f0f0f0; padding: 5px; margin-top: 20px; margin-bottom: 10px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            color: #fff;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .bg-info { background-color: #17a2b8; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Profil Étudiant</h1>
            <h2>{{ $etudiant->nom }} {{ $etudiant->prenom }}</h2>
            <p>Matricule: {{ $etudiant->matricule }}</p>
        </div>

        <div class="section-title">Informations Personnelles</div>
        <table>
            <tr><th>Date de naissance</th><td>{{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</td></tr>
            <tr><th>Lieu de naissance</th><td>{{ $etudiant->lieu_naissance ?? 'N/A' }}</td></tr>
            <tr><th>Sexe</th><td>{{ $etudiant->sexe }}</td></tr>
            <tr><th>Email Personnel</th><td>{{ $etudiant->email_perso }}</td></tr>
            <tr><th>Téléphone</th><td>{{ $etudiant->telephone_perso ?? 'N/A' }}</td></tr>
            <tr><th>Adresse</th><td>{{ $etudiant->adresse_postale ?? 'N/A' }}</td></tr>
        </table>

        @if($etudiant->inscriptionAdmins->isNotEmpty())
        <div class="section-title">Inscriptions Administratives</div>
        @foreach($etudiant->inscriptionAdmins as $inscription)
            <h4>Année Académique: {{ $inscription->annee_academique }}</h4>
            <table>
                <tr><th>Parcours</th><td>{{ $inscription->parcours->nom ?? 'N/A' }} ({{ $inscription->parcours->filiere->nom ?? 'N/A' }})</td></tr>
                <tr><th>Statut</th><td>{{ $inscription->statut }}</td></tr>
                <tr><th>Date d'inscription</th><td>{{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}</td></tr>
            </table>

            @if($inscription->notes->isNotEmpty())
            <div class="section-title">Notes ({{ $inscription->annee_academique }})</div>
            <table>
                <thead>
                    <tr><th>Module / Évaluation</th><th>Note</th><th>Appréciation</th></tr>
                </thead>
                <tbody>
                    @foreach($inscription->notes as $note)
                    <tr>
                        <td>{{ $note->evaluation->module->libelle ?? 'N/A' }} ({{ $note->evaluation->libelle ?? 'N/A' }})</td>
                        <td>
                            @if($note->est_absent)
                                <span class="badge bg-danger">Absent</span>
                            @else
                                {{ $note->note_obtenue }}/{{ $note->evaluation->bareme_total }}
                            @endif
                        </td>
                        <td>{{ $note->appreciation ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if($inscription->stages->isNotEmpty())
            <div class="section-title">Stages ({{ $inscription->annee_academique }})</div>
            <table>
                <thead>
                    <tr><th>Sujet</th><th>Entreprise</th><th>Dates</th><th>Statut</th></tr>
                </thead>
                <tbody>
                    @foreach($inscription->stages as $stage)
                    <tr>
                        <td>{{ $stage->sujet_stage }}</td>
                        <td>{{ $stage->entreprise->nom_entreprise ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($stage->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($stage->date_fin)->format('d/m/Y') }}</td>
                        <td><span class="badge bg-info">{{ $stage->statut_validation }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if($etudiant->documents->isNotEmpty())
            <div class="section-title">Documents</div>
            <ul>
                @foreach($etudiant->documents as $document)
                    <li>{{ $document->nom_fichier }} ({{ $document->type_document }})</li>
                @endforeach
            </ul>
            @endif

        @endforeach
        @endif
    </div>
</body>
</html>
