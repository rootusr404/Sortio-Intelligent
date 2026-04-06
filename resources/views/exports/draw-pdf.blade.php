<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Procès-verbal de tirage - {{ $draw->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #16a34a;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #f3f4f6;
            padding: 8px 12px;
            font-weight: bold;
            margin-bottom: 10px;
            border-left: 4px solid #16a34a;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            width: 30%;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        .groups-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .group-box {
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 4px;
            width: 48%;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .group-title {
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .group-members {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .group-members li {
            padding: 3px 0;
            border-bottom: 1px dotted #e5e7eb;
        }
        .certificate {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .certificate-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .hash-code {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 8px;
            border-radius: 3px;
            word-break: break-all;
            font-size: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #666;
        }
        .rgpd-notice {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PROCÈS-VERBAL DE TIRAGE AU SORT</h1>
        <p><strong>{{ $draw->title }}</strong></p>
        <p>Généré le {{ now()->format('d/m/Y à H:i:s') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Informations générales</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Organisateur :</div>
                <div class="info-value">{{ $draw->user->first_name }} {{ $draw->user->last_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Organisation :</div>
                <div class="info-value">{{ $draw->user->organization ?? 'Non renseigné' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date du tirage :</div>
                <div class="info-value">{{ $draw->created_at->format('d/m/Y à H:i:s') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Mode de répartition :</div>
                <div class="info-value">{{ $draw->type === 'A' ? 'Par groupes de taille définie' : 'Par thèmes de travail' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nombre de participants :</div>
                <div class="info-value">{{ $draw->participant_count }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Algorithme utilisé :</div>
                <div class="info-value">Fisher-Yates (mélange non biaisé)</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Résultats du tirage</div>
        <div class="groups-container">
            @foreach($groups as $key => $members)
                <div class="group-box">
                    <div class="group-title">
                        @if($draw->type === 'A')
                            Groupe {{ $key }} ({{ count($members) }} personnes)
                        @else
                            {{ $key }} ({{ count($members) }} personnes)
                        @endif
                    </div>
                    <ul class="group-members">
                        @foreach($members as $member)
                            <li>{{ $member->full_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <div class="certificate">
        <div class="certificate-title">🔒 CERTIFICAT D'AUTHENTICITÉ SHA-256</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Seed cryptographique :</div>
                <div class="info-value"><code>{{ substr($draw->seed, 0, 32) }}...</code></div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de verrouillage :</div>
                <div class="info-value">{{ $draw->locked_at->format('d/m/Y H:i:s') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Participants hashés :</div>
                <div class="info-value">{{ $draw->participant_count }}</div>
            </div>
        </div>
        <div style="margin-top: 10px;">
            <strong>Hash SHA-256 :</strong>
            <div class="hash-code">{{ $draw->hash_code }}</div>
        </div>
        <p style="margin-top: 10px; font-size: 10px; color: #1e40af;">
            Ce hash garantit l'authenticité du tirage. Toute modification des données invaliderait ce certificat.
            Vérification publique disponible sur : sortio.app/verify
        </p>
    </div>

    <div class="rgpd-notice">
        <strong>RGPD - Protection des données personnelles</strong><br>
        Les données nominatives figurant dans ce document ont été collectées et traitées conformément au Règlement Général sur la Protection des Données (RGPD - Règlement UE 2016/679).<br>
        <strong>Responsable du traitement :</strong> {{ $draw->user->first_name }} {{ $draw->user->last_name }} ({{ $draw->user->email }})<br>
        <strong>Durée de conservation :</strong> 12 mois<br>
        <strong>Droit de suppression :</strong> Les participants peuvent demander la suppression de leurs données en contactant l'organisateur.
    </div>

    <div class="footer">
        <p><strong>Sortio Intelligent</strong> - Plateforme de tirage au sort certifié</p>
        <p>Document généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}</p>
        <p>ID du tirage : {{ $draw->id }} | Hash : {{ substr($draw->hash_code, 0, 16) }}...</p>
    </div>
</body>
</html>
