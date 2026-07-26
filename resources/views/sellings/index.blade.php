<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selling - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Mobile Header -->
        <header class="lg:hidden bg-gradient-to-r from-indigo-900 to-indigo-800 text-white p-4 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="ml-3 text-xl font-bold flex items-center">
                        <i class="fas fa-cube mr-2"></i>
                        Kalmi Gestion
                    </h1>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm">{{ now()->format('H:i') }}</span>
                    <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-sm">
                        {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Navigation Drawer -->
        <div id="mobileMenuDrawer" class="lg:hidden fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
            <nav class="absolute left-0 top-0 h-full w-72 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white shadow-xl transform transition-transform duration-300" id="mobileMenuNav">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold flex items-center"><i class="fas fa-cube mr-2"></i> Menu</h2>
                        <button onclick="toggleMobileMenu()" type="button" class="p-2 rounded-lg hover:bg-indigo-700 transition-colors"><i class="fas fa-times text-xl"></i></button>
                    </div>
                    @php $r = request()->route()->getName(); @endphp
                    <ul class="space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition {{ $r == 'dashboard' ? 'bg-indigo-700' : '' }}"><i class="fas fa-tachometer-alt w-5 mr-3"></i> Tableau de bord</a></li>
                        @if(auth()->check() && (auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin'))
                            <li><a href="{{ route('sellings.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ $r == 'sellings.index' || $r == 'sellings.create' || $r == 'sellings.edit' ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition"><i class="fas fa-cash-register w-5 mr-3"></i> Selling</a></li>
                            <li><a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-shopping-cart w-5 mr-3"></i> Ventes</a></li>
                            <li><a href="{{ route('deliveries.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-truck w-5 mr-3"></i> Livraisons</a></li>
                            <li><a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-money-bill-wave w-5 mr-3"></i> Dépenses</a></li>
                        @endif
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <li><a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-box w-5 mr-3"></i> Produits</a></li>
                            <li><a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-tags w-5 mr-3"></i> Catégories</a></li>
                            <li><a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-chart-bar w-5 mr-3"></i> Rapports</a></li>
                        @endif
                    </ul>
                    <div class="mt-6 pt-6 border-t border-indigo-700">
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium"><i class="fas fa-sign-out-alt mr-2"></i> Déconnexion</button></form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex lg:w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white flex-col">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center"><i class="fas fa-cube mr-2"></i> Kalmi Gestion</h1>
            </div>
            <nav class="flex-1 px-4">
                <ul class="space-y-2">
                    @php $r = request()->route()->getName(); @endphp
                    <li><a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition {{ $r == 'dashboard' ? 'bg-indigo-700' : '' }}"><i class="fas fa-tachometer-alt w-5 mr-3"></i> Tableau de bord</a></li>
                    @if(auth()->check() && (auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin'))
                        <li><a href="{{ route('sellings.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ $r == 'sellings.index' || $r == 'sellings.create' || $r == 'sellings.edit' ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition"><i class="fas fa-cash-register w-5 mr-3"></i> Selling</a></li>
                        <li><a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-shopping-cart w-5 mr-3"></i> Ventes</a></li>
                        <li><a href="{{ route('deliveries.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-truck w-5 mr-3"></i> Livraisons</a></li>
                        <li><a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-money-bill-wave w-5 mr-3"></i> Dépenses</a></li>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <li><a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-box w-5 mr-3"></i> Produits</a></li>
                        <li><a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-tags w-5 mr-3"></i> Catégories</a></li>
                        <li><a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-chart-bar w-5 mr-3"></i> Rapports</a></li>
                    @endif
                </ul>
            </nav>
            <div class="p-4 border-t border-indigo-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center font-bold">{{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}</div>
                    <div class="ml-3">
                        <p class="font-medium">{{ auth()->user() ? auth()->user()->name : 'Utilisateur' }}</p>
                        <p class="text-sm text-indigo-300">{{ auth()->user() ? auth()->user()->role : 'Inconnu' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf<button type="submit" class="w-full px-4 py-2 bg-indigo-700 rounded-lg hover:bg-indigo-600 transition text-sm"><i class="fas fa-sign-out-alt mr-2"></i> Déconnexion</button></form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="hidden lg:block bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">Selling</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>
                        <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900"><i class="fas fa-user-circle text-2xl"></i></a>
                    </div>
                </div>
            </header>

            <main class="p-3 sm:p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-semibold opacity-90">Total des ventes</h3>
                                <p class="text-3xl font-bold">{{ number_format($totalSellings ?? 0, 2, ',', ' ') }} FCFA</p>
                            </div>
                            <div class="text-4xl opacity-80"><i class="fas fa-cash-register"></i></div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-semibold opacity-90">Ventes du jour</h3>
                                <p class="text-3xl font-bold">{{ number_format($todaySellings ?? 0, 2, ',', ' ') }} FCFA</p>
                            </div>
                            <div class="text-4xl opacity-80"><i class="fas fa-calendar-day"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Header with actions -->
                <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Selling</h2>
                        <p class="text-sm text-gray-600 mt-1">Gestion des ventes journalières</p>
                    </div>
                    <a href="{{ route('sellings.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition inline-flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Nouvelle vente
                    </a>
                </div>

                <!-- Search -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('sellings.index') }}" class="flex flex-col lg:flex-row gap-3">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ $query ?? '' }}" placeholder="Rechercher une note..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button type="submit" class="px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-search mr-2"></i> Rechercher</button>
                        @if($query ?? false)
                            <a href="{{ route('sellings.index') }}" class="px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition inline-flex items-center justify-center"><i class="fas fa-times mr-2"></i> Effacer</a>
                        @endif
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        @if(($sellings ?? collect())->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($sellings ?? collect() as $selling)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $selling->selling_date->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $selling->product->name ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">{{ number_format($selling->amount, 2, ',', ' ') }} FCFA</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $selling->notes ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $selling->user->name ?? 'Inconnu' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('sellings.edit', $selling) }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i></a>
                                                    <form method="POST" action="{{ route('sellings.destroy', $selling) }}" class="inline" onsubmit="showGlobalLoader(); return true;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">{{ $sellings->links() }}</div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-cash-register text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune vente trouvée</h3>
                                <p class="text-gray-500 mb-6">Vous n'avez pas encore enregistré de ventes.</p>
                                <a href="{{ route('sellings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"><i class="fas fa-plus mr-2"></i> Ajouter une vente</a>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const drawer = document.getElementById('mobileMenuDrawer');
            const nav = document.getElementById('mobileMenuNav');
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                setTimeout(() => nav.classList.remove('-translate-x-full'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                nav.classList.add('-translate-x-full');
                setTimeout(() => drawer.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        }
    </script>
@include('components.loading')
</body>
</html>
