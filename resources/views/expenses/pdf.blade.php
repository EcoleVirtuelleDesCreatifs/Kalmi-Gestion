<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Dépenses - Kalmi Gestion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e5e5;
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
            font-size: 18px;
        }
        
        .header p {
            color: #6b7280;
            margin: 5px 0;
            font-size: 14px;
        }
        
        .summary {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .summary-row:last-child {
            margin-bottom: 0;
            font-weight: bold;
            font-size: 16px;
            color: #dc2626;
            border-top: 1px solid #fecaca;
            padding-top: 8px;
        }
        
        .filters {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 13px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-align: left;
            padding: 12px 8px;
            border: 1px solid #e5e7eb;
            font-size: 12px;
        }
        
        .table td {
            padding: 10px 8px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }
        
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
            color: #dc2626;
        }
        
        .category {
            background-color: #fef2f2;
            color: #dc2626;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .description {
            max-width: 200px;
        }
        
        .notes {
            color: #6b7280;
            font-style: italic;
            font-size: 11px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e5e5;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💰 KALMI GESTION</h1>
            <h2>RAPPORT DES DÉPENSES</h2>
            <p>Date d'édition : {{ date('d/m/Y H:i:s') }}</p>
        </div>

        <div class="summary">
            <div class="summary-row">
                <strong>Nombre total de dépenses :</strong>
                <span>{{ $expenses->count() }}</span>
            </div>
            <div class="summary-row">
                <strong>Montant total des dépenses :</strong>
                <span>{{ number_format($totalExpenses, 2, ',', ' ') }} FCFA</span>
            </div>
            <div class="summary-row">
                <strong>Dépense moyenne :</strong>
                <span>{{ $expenses->count() > 0 ? number_format($totalExpenses / $expenses->count(), 2, ',', ' ') : '0,00' }} FCFA</span>
            </div>
        </div>

        @if($query || $category)
            <div class="filters">
                <strong>Filtres appliqués :</strong><br>
                @if($query)
                    <strong>Recherche :</strong> "{{ $query }}"<br>
                @endif
                @if($category)
                    <strong>Catégorie :</strong> {{ $category }}<br>
                @endif
            </div>
        @endif

        @if($expenses->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Montant</th>
                        <th>Reçu</th>
                        <th>Utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                            <td class="description">
                                <strong>{{ $expense->description }}</strong>
                                @if($expense->notes)
                                    <br><span class="notes">{{ $expense->notes }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="category">{{ $expense->category }}</span>
                            </td>
                            <td class="amount">{{ number_format($expense->amount, 2, ',', ' ') }} FCFA</td>
                            <td>{{ $expense->receipt_number ?? '-' }}</td>
                            <td>{{ $expense->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <i class="fas fa-money-bill-wave" style="font-size: 48px; margin-bottom: 15px; color: #d1d5db;"></i>
                <h3>Aucune dépense trouvée</h3>
                <p>@if($query || $category) Aucune dépense ne correspond aux critères de recherche. @else Aucune dépense n'a été enregistrée. @endif</p>
            </div>
        @endif

        <div class="footer">
            <p>Document généré par Kalmi Gestion - Système de Gestion Commerciale</p>
            <p>{{ date('d/m/Y à H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
