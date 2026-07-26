<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouvelle vente - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        @include('sellings.partials.sidebar')

        <div class="flex-1 flex flex-col">
            <header class="hidden lg:block bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">Nouvelle vente</h2>
                    <span class="text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </header>

            <main class="p-3 sm:p-4 lg:p-6">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Enregistrer une vente</h3>

                        <form method="POST" action="{{ route('sellings.store') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date de la vente</label>
                                <input type="date" name="selling_date" value="{{ old('selling_date', date('Y-m-d')) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                @error('selling_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Montant (FCFA)</label>
                                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" placeholder="0.00" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                @error('amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                                <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('notes') }}</textarea>
                                @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <a href="{{ route('sellings.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Annuler</a>
                                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-save mr-2"></i> Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
@include('components.loading')
</body>
</html>
