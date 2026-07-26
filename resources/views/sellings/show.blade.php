<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détail vente - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        @include('sellings.partials.sidebar')

        <div class="flex-1 flex flex-col">
            <header class="hidden lg:block bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">Détail de la vente</h2>
                    <span class="text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </header>

            <main class="p-3 sm:p-4 lg:p-6">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $selling->selling_date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Montant</p>
                                <p class="text-lg font-semibold text-green-600">{{ number_format($selling->amount, 2, ',', ' ') }} FCFA</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Produit</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $selling->product->name ?? 'Aucun' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Notes</p>
                                <p class="text-gray-800">{{ $selling->notes ?? 'Aucune note' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Enregistré par</p>
                                <p class="text-gray-800">{{ $selling->user->name ?? 'Inconnu' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date d'enregistrement</p>
                                <p class="text-gray-800">{{ $selling->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('sellings.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"><i class="fas fa-arrow-left mr-2"></i> Retour</a>
                            <div class="flex gap-2">
                                <a href="{{ route('sellings.edit', $selling) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"><i class="fas fa-edit mr-2"></i> Modifier</a>
                                <form method="POST" action="{{ route('sellings.destroy', $selling) }}" onsubmit="showGlobalLoader(); return true;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"><i class="fas fa-trash mr-2"></i> Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@include('components.loading')
</body>
</html>
