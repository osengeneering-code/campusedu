<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de Candidature</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; }
        h1, h2 { color: #0056b3; }
        ul { list-style: none; padding: 0; }
        ul li { margin-bottom: 8px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour {{ $candidature->prenom }} {{ $candidature->nom }},</h1>

        <p>Nous avons bien reçu votre candidature pour la pré-inscription chez [Nom de votre Établissement].</p>

        <h2>Récapitulatif de votre candidature :</h2>
        <ul>
            <li><strong>Nom complet:</strong> {{ $candidature->prenom }} {{ $candidature->nom }}</li>
            <li><strong>Email:</strong> {{ $candidature->email }}</li>
            <li><strong>Téléphone:</strong> {{ $candidature->telephone }}</li>
            <li><strong>Date de naissance:</strong> {{ \Carbon\Carbon::parse($candidature->date_naissance)->format('d/m/Y') }}</li>
            <li><strong>Nationalité:</strong> {{ $candidature->nationalite ?? 'N/A' }}</li>
            <li><strong>Sexe:</strong> {{ $candidature->sexe ?? 'N/A' }}</li>
        </ul>

        <h3>Formation souhaitée :</h3>
        <ul>
            <li><strong>Année d'Admission:</strong> {{ $candidature->annee_admission ?? 'N/A' }}</li>
            <li><strong>Niveau d'Étude Demandé:</strong> {{ $candidature->type_niveau ?? 'N/A' }}</li>
            <li><strong>Parcours Souhaité:</strong> {{ $candidature->parcours->nom ?? 'N/A' }}</li>
            <li><strong>Spécialité:</strong> {{ $candidature->specialite_souhaitee ?? 'N/A' }}</li>
            <li><strong>Type d'Inscription:</strong> {{ $candidature->type_inscription ?? 'N/A' }}</li>
        </ul>

        @if($candidature->nom_tuteur)
        <h3>Informations Tuteur :</h3>
        <ul>
            <li><strong>Nom Tuteur:</strong> {{ $candidature->prenom_tuteur }} {{ $candidature->nom_tuteur }}</li>
            <li><strong>Téléphone Tuteur:</strong> {{ $candidature->telephone_tuteur ?? 'N/A' }}</li>
            <li><strong>Lien de Parenté:</strong> {{ $candidature->lien_parente_tuteur ?? 'N/A' }}</li>
        </ul>
        @endif

        <p>Votre demande est en cours de traitement. Nous vous contacterons prochainement pour les étapes suivantes.</p>
        <p>Vous pouvez consulter le statut de votre candidature en vous connectant à votre espace (si disponible) ou en contactant notre administration.</p>

        <div class="footer">
            <p>Cordialement,</p>
            <p>L'équipe de [Nom de votre Établissement]</p>
        </div>
    </div>
</body>
</html>