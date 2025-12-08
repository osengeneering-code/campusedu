<!DOCTYPE html>
<html>
<head>
    <title>Reçu de Paiement #{{ $paiement->reference_paiement }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                Votre Logo
                            </td>
                            <td>
                                Reçu #: {{ $paiement->reference_paiement }}<br>
                                Date de paiement: {{ $paiement->date_paiement->format('d/m/Y') }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                École Supérieure<br>
                                Adresse 1<br>
                                Ville, Pays
                            </td>
                            <td>
                                Étudiant: {{ $paiement->inscriptionAdmin->etudiant->nom }} {{ $paiement->inscriptionAdmin->etudiant->prenom }}<br>
                                Matricule: {{ $paiement->inscriptionAdmin->etudiant->matricule }}<br>
                                Email: {{ $paiement->inscriptionAdmin->etudiant->email_perso }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Détails du Paiement</td>
                <td></td>
            </tr>
            <tr class="details">
                <td>Type de frais</td>
                <td>{{ $paiement->type_frais }}</td>
            </tr>
            <tr class="details">
                <td>Année Académique</td>
                <td>{{ $paiement->inscriptionAdmin->annee_academique }}</td>
            </tr>
            <tr class="details">
                <td>Méthode de paiement</td>
                <td>{{ $paiement->methode_paiement }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>
                   Total: {{ number_format($paiement->montant, 2, ',', ' ') }} F CFA
                </td>
            </tr>
        </table>
        <p style="text-align: center; margin-top: 50px;">Merci pour votre paiement.</p>
    </div>
</body>
</html>
