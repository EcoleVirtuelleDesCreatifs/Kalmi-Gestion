<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Commandes - Kalmi Gestion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .summary {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        .order-number {
            font-weight: bold;
            color: #4f46e5;
        }
        .total-amount {
            font-weight: bold;
            color: #059669;
        }
        .status-delivered {
            color: #059669;
            font-weight: bold;
        }
        .status-pending {
            color: #d97706;
            font-weight: bold;
        }
        .status-none {
            color: #6b7280;
            font-style: italic;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #666;
            font-size: 10px;
        }
        .products-list {
            font-size: 10px;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kalmi Gestion</h1>
        <p>Rapport des Commandes</p>
        <p>Généré le {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-row">
            <strong>Nombre total de commandes:</strong>
            <span>{{ $orders->count() }}</span>
        </div>
        <div class="summary-row">
            <strong>Montant total:</strong>
            <span class="total-amount">{{ number_format($orders->sum('total_amount'), 2) }} FCFA</span>
        </div>
        <div class="summary-row">
            <strong>Période:</strong>
            <span>
                @if($orders->isNotEmpty())
                    {{ $orders->last()->created_at->format('d/m/Y') }} - 
                    {{ $orders->first()->created_at->format('d/m/Y') }}
                @else
                    Aucune commande
                @endif
            </span>
        </div>
    </div>

    @if($orders->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Numéro Facture</th>
                    <th>Date</th>
                    <th>Vendeur</th>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Montant Total</th>
                    <th>Produits</th>
                    <th>Livraison</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="order-number">{{ $order->invoice_number }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->customer_name ?? 'Non spécifié' }}</td>
                        <td>{{ $order->customer_phone ?? 'Non spécifié' }}</td>
                        <td class="total-amount">{{ number_format($order->total_amount, 2) }} FCFA</td>
                        <td class="products-list">
                            {{ $order->orderItems->map(function($item) {
                                return $item->product->name . ' (' . $item->quantity . ')';
                            })->implode(', ') }}
                        </td>
                        <td>
                            @if($order->delivery)
                                <span class="status-delivered">{{ $order->delivery->status }}</span>
                            @else
                                <span class="status-none">Non livré</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 20px;">
            Aucune commande trouvée pour la période sélectionnée.
        </p>
    @endif

    <div class="footer">
        <p>Kalmi Gestion - Système de Gestion Commerciale</p>
        <p>Ce rapport est généré automatiquement et ne nécessite pas de signature.</p>
    </div>
</body>
</html>
