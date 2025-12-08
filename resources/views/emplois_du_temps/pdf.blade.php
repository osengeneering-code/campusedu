<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Emploi du Temps</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        header { text-align: center; margin-bottom: 20px; }
        header img { height: 60px; }
        h1 { font-size: 28px; margin: 10px 0; text-transform: uppercase; }
        h3 { font-size: 16px; margin: 5px 0; }
        table { border-collapse: collapse; width: 100%; page-break-inside: avoid; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; vertical-align: top; }
        th { background-color: #f2f2f2; }
        .course-block {
            background-color: #2a9e1f;
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 10px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('logo.png') }}" alt="Logo">
    <h1>Nom de l'Établissement</h1>
    <h1>EMPLOI DU TEMPS</h1>
    @if(request('id_filiere'))
        <h3>Filière : {{ $filieres->find(request('id_filiere'))->nom ?? 'N/A' }}</h3>
    @endif
    @if(request('id_parcour'))
        <h3>Parcours : {{ $parcours->find(request('id_parcour'))->nom ?? 'N/A' }}</h3>
    @endif
    @if(request('id_semestre'))
        <h3>Semestre : {{ $semestres->find(request('id_semestre'))->libelle ?? 'N/A' }}</h3>
    @endif
</header>

<table>
    <thead>
        <tr>
            <th>Heure</th>
            @foreach($jours as $jour)
                <th>{{ $jour }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $start_time = 8;
            $end_time = 19;
        @endphp
        @for ($hour = $start_time; $hour < $end_time; $hour++)
            <tr>
                <td>{{ sprintf('%02d', $hour) }}:00</td>
                @foreach($jours as $jour)
                    <td>
                        @if(isset($cours[$jour]))
                            @foreach($cours[$jour] as $c)
                                @if((int)substr($c->heure_debut, 0, 2) == $hour)
                                    <div class="course-block">
                                        <strong>{{ $c->type_cours }} - {{ $c->module->libelle ?? 'N/A' }}</strong><br>
                                        Salle : {{ $c->salle->nom_salle ?? 'N/A' }}<br>
                                        {{ substr($c->heure_debut,0,5) }} - {{ substr($c->heure_fin,0,5) }}
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </td>
                @endforeach
            </tr>
        @endfor
    </tbody>
</table>

<footer style="text-align:center; margin-top: 20px;">
    <p style="font-size: 12px;">Filière : {{ $filieres->find(request('id_filiere'))->nom ?? 'N/A' }} | Parcours : {{ $parcours->find(request('id_parcour'))->nom ?? 'N/A' }} | Semestre : {{ $semestres->find(request('id_semestre'))->libelle ?? 'N/A' }}</p>
</footer>

</body>
</html>
