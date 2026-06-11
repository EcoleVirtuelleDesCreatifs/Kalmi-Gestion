<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche de Livraison Journalière - Kalmi Gestion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #dc2626;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header h2 {
            color: #374151;
            margin: 5px 0;
            font-size: 20px;
        }
        .header p {
            color: #666;
            margin: 3px 0;
            font-size: 14px;
        }
        .summary {
            background-color: #fef2f2;
            border: 2px solid #fecaca;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .summary-row strong {
            color: #991b1b;
        }
        .instructions {
            background-color: #f0f9ff;
            border: 2px solid #bae6fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .instructions h3 {
            color: #1e40af;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .instructions ul {
            margin: 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 5px;
            color: #1e3a8a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
            font-size: 12px;
        }
        .order-number {
            font-weight: bold;
            color: #dc2626;
            font-size: 12px;
        }
        .customer-name {
            font-weight: bold;
            color: #1f2937;
        }
        .customer-phone {
            color: #059669;
            font-weight: bold;
        }
        .address {
            font-style: italic;
            color: #4b5563;
        }
        .products-list {
            font-size: 10px;
            color: #4b5563;
            background-color: #f9fafb;
            padding: 5px;
            border-radius: 4px;
        }
        .total-amount {
            font-weight: bold;
            color: #059669;
            font-size: 12px;
        }
        .status {
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            text-align: center;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background-color: #ddd6fe;
            color: #5b21b6;
        }
        .checkbox-section {
            margin-top: 5px;
            border: 1px solid #d1d5db;
            padding: 8px;
            border-radius: 4px;
            background-color: #fafafa;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            margin-bottom: 3px;
            font-size: 10px;
        }
        .checkbox {
            width: 12px;
            height: 12px;
            margin-right: 8px;
            border: 1px solid #6b7280;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            color: #666;
            font-size: 10px;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            border-top: 1px solid #374151;
            padding-top: 20px;
            font-size: 11px;
            color: #374151;
        }
        .no-deliveries {
            text-align: center;
            color: #6b7280;
            font-style: italic;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚚 KALMI GESTION</h1>
        <h2>FICHE DE LIVRAISON JOURNALIÈRE</h2>
        <p>Date : {{ date('d/m/Y', strtotime($date)) }}</p>
        <p>Émise le : {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-row">
            <strong>Nombre total de livraisons :</strong>
            <span>{{ $deliveries->count() }}</span>
        </div>
        <div class="summary-row">
            <strong>Montant total à livrer :</strong>
            <span class="total-amount">{{ number_format($deliveries->sum('order.total_amount'), 2) }} FCFA</span>
        </div>
        <div class="summary-row">
            <strong>Livreur :</strong>
            <span>_________________________</span>
        </div>
    </div>

    <div class="instructions">
        <h3>📋 INSTRUCTIONS POUR LE LIVREUR</h3>
        <ul>
            <li>Vérifier chaque commande avant de partir</li>
            <li>Confirmer les produits et quantités</li>
            <li>Appeler le client avant la livraison</li>
            <li>Faire signer le client sur la fiche</li>
            <li>Retourner la fiche complétée au bureau</li>
            <li>Signaler tout problème immédiatement</li>
        </ul>
    </div>

    @if($deliveries->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th width="5%">N°</th>
                    <th width="15%">Client</th>
                    <th width="20%">Adresse</th>
                    <th width="20%">Téléphone</th>
                    <th width="25%">Produits</th>
                    <th width="10%">Total</th>
                    <th width="5%">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveries as $index => $delivery)
                    <tr>
                        <td class="order-number">{{ $delivery->order->invoice_number }}</td>
                        <td>
                            <div class="customer-name">{{ $delivery->order->customer_name ?? 'Client' }}</div>
                            <small>Vendeur: {{ $delivery->order->user->name }}</small>
                        </td>
                        <td class="address">{{ $delivery->delivery_address ?? 'À confirmer' }}</td>
                        <td class="customer-phone">{{ $delivery->order->customer_phone ?? 'Non spécifié' }}</td>
                        <td class="products-list">
                            @foreach($delivery->order->orderItems as $item)
                                • {{ $item->product->name }} ({{ $item->quantity }})<br>
                            @endforeach
                        </td>
                        <td class="total-amount">{{ number_format($delivery->order->total_amount, 2) }} FCFA</td>
                        <td>
                            <span class="status
                                @if($delivery->status === 'En cours de livraison') status-processing
                                @else status-pending @endif">
                                {{ $delivery->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div class="checkbox-section">
                                <div class="checkbox-row">
                                    <span class="checkbox"></span>
                                    ☐ Commande vérifiée et complète
                                </div>
                                <div class="checkbox-row">
                                    <span class="checkbox"></span>
                                    ☐ Client appelé - {{ $delivery->order->customer_phone ?? 'N/A' }}
                                </div>
                                <div class="checkbox-row">
                                    <span class="checkbox"></span>
                                    ☐ Livraison effectuée le : _________________ à : _________
                                </div>
                                <div class="checkbox-row">
                                    <span class="checkbox"></span>
                                    ☐ Signature client : _________________________
                                </div>
                                <div class="checkbox-row">
                                    <span class="checkbox"></span>
                                    ☐ Observations : ___________________________________
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <strong>SIGNATURE DU LIVREUR</strong><br>
                <br><br><br>
                Nom : _________________________
            </div>
            <div class="signature-box">
                <strong>SIGNATURE RESPONSABLE</strong><br>
                <br><br><br>
                Nom : _________________________
            </div>
        </div>
    @else
        <div class="no-deliveries">
            <h3>📦 AUCUNE LIVRAISON PRÉVUE AUJOURD'HUI</h3>
            <p>Toutes les commandes du jour ont été livrées ou annulées.</p>
        </div>
    @endif

    <div class="footer">
        <p><strong>Kalmi Gestion</strong> - Système de Gestion Commerciale</p>
        <p>Cette fiche est un document officiel. Toute modification doit être autorisée par la direction.</p>
        <p>En cas de problème, contacter : ___________________________</p>
    </div>
</body>
</html>
