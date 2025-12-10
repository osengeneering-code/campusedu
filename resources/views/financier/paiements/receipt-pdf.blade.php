<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement #{{ $paiement->reference_paiement }}</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 11pt;
            margin: 20px;
            background-color: #f8f9fa;
        }

        .invoice-box {
            max-width: 800px;
            background: #fff;
            margin: auto;
            padding: 25px 35px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        h2, h3 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .header {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .school-info, .student-info {
            font-size: 10.5pt;
            color: #444;
            line-height: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table th {
            background: #0d6efd;
            color: #fff;
            padding: 10px;
            font-weight: bold;
            text-align: left;
            font-size: 11pt;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 11pt;
        }

        .total-row td {
            font-size: 13pt;
            font-weight: bold;
            color: #0d6efd;
            border-top: 2px solid #0d6efd;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #555;
            font-size: 11pt;
        }
    </style>
</head>

<body>

    <div class="invoice-box">

        <!-- ENTÊTE -->
        <div class="header">
            <table width="100%">
                <tr>
                    <td>
                        <h2>École Supérieure</h2>
                        <div class="school-info">
                            Adresse 1<br>
                            Ville, Pays
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <h3>Reçu de Paiement</h3>
                        <strong>Réf :</strong> {{ $paiement->reference_paiement }}<br>
                        <strong>Date :</strong> {{ \Carbon\Carbon::parse($paiement->date_paiement)->translatedFormat('d F Y') }}

                    </td>
                </tr>
            </table>
        </div>

        <!-- INFOS ÉTUDIANT -->
        <h3>Informations Étudiant</h3>
        <table>
            <tr>
                <td><strong>Nom & Prénom :</strong></td>
                <td>{{ $paiement->inscriptionAdmin->etudiant->nom }} {{ $paiement->inscriptionAdmin->etudiant->prenom }}</td>
            </tr>
            <tr>
                <td><strong>Matricule :</strong></td>
                <td>{{ $paiement->inscriptionAdmin->etudiant->matricule }}</td>
            </tr>
            <tr>
                <td><strong>Email :</strong></td>
                <td>{{ $paiement->inscriptionAdmin->etudiant->email_perso }}</td>
            </tr>
        </table>

        <!-- DETAILS PAIEMENT -->
        <h3 style="margin-top: 30px;">Détails du Paiement</h3>
        <table>
            <tr>
                <th>Description</th>
                <th style="text-align:right;">Valeur</th>
            </tr>

            <tr>
                <td>Type de frais</td>
                <td style="text-align:right;">{{ $paiement->type_frais }}</td>
            </tr>

            <tr>
                <td>Année Académique</td>
                <td style="text-align:right;">{{ $paiement->inscriptionAdmin->annee_academique }}</td>
            </tr>

            <tr>
                <td>Méthode de paiement</td>
                <td style="text-align:right;">{{ $paiement->methode_paiement }}</td>
            </tr>

            <tr class="total-row">
                <td>Total Payé</td>
                <td style="text-align:right;">
                    {{ number_format($paiement->montant, 2, ',', ' ') }} F CFA
                </td>
            </tr>
        </table>

        <!-- FOOTER -->
        <p class="footer">Merci pour votre paiement.</p>

    </div>

</body>
</html>
