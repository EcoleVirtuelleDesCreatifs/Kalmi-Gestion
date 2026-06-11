<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Livraisons - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Mobile Header -->
        <header class="lg:hidden bg-gradient-to-r from-indigo-900 to-indigo-800 text-white p-4 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button onclick="toggleMobileMenu()"
                            class="p-2 rounded-lg hover:bg-indigo-700 transition-colors">
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
                        {{ substr(auth()->user()->name, 0, 1) }}
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
                        <h2 class="text-xl font-bold flex items-center">
                            <i class="fas fa-cube mr-2"></i>
                            Menu
                        </h2>
                        <button onclick="toggleMobileMenu()"
                                type="button"
                                class="p-2 rounded-lg hover:bg-indigo-700 transition-colors focus:outline-none">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <!-- User Info Mobile -->
                    <div class="mb-6 p-4 bg-indigo-800 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-indigo-300">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                    </div>

                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                <i class="fas fa-home w-5 mr-3"></i>
                                Dashboard
                            </a>
                        </li>

                        @if (auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ route('orders.create') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('orders.create') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-plus-circle w-5 mr-3"></i>
                                    Nouvelle Vente
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('orders.index') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('orders.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-shopping-cart w-5 mr-3"></i>
                                    Commandes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('deliveries.index') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('deliveries.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-truck w-5 mr-3"></i>
                                    Livraisons
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('expenses.index') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('expenses.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                                    Dépenses
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ route('categories.index') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('categories.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-tags w-5 mr-3"></i>
                                    Catégories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.index') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('products.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-box w-5 mr-3"></i>
                                    Produits
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.index') }}"
                                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('reports.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                                    Rapports
                                </a>
                            </li>
                        @endif
                    </ul>

                    <!-- Logout Mobile -->
                    <div class="mt-6 pt-6 border-t border-indigo-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex lg:w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white flex-col">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-cube mr-2"></i>
                    Kalmi Gestion
                </h1>
            </div>

            <nav class="mt-6">
                <ul class="space-y-2 px-4">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-home w-5 mr-3"></i>
                            Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('orders.create') }}"
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-plus-circle w-5 mr-3"></i>
                                Nouvelle Vente
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}"
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-shopping-cart w-5 mr-3"></i>
                                Commandes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('deliveries.index') }}"
                               class="flex items-center px-4 py-3 rounded-lg bg-indigo-700">
                                <i class="fas fa-truck w-5 mr-3"></i>
                                Livraisons
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expenses.index') }}"
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                                Dépenses
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('categories.index') }}"
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-tags w-5 mr-3"></i>
                                Catégories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}"
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-box w-5 mr-3"></i>
                                Produits
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.index') }}"
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-chart-bar w-5 mr-3"></i>
                                Rapports
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-indigo-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-indigo-300">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-700 rounded-lg hover:bg-indigo-600 transition text-sm">
                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Desktop Top Bar -->
            <header class="hidden lg:block bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">Livraisons</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>
                        <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Mobile Top Bar (simplified) -->
            <header class="lg:hidden bg-white shadow-sm px-4 py-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-800">Livraisons</h2>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 sm:p-4 lg:p-6">
                <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Livraisons</h2>
                        <p class="text-sm text-gray-600 mt-1">Suivi des livraisons et statuts</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        <a href="{{ route('deliveries.past-sheets') }}" class="px-3 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm sm:text-base inline-flex items-center justify-center">
                            <i class="fas fa-history mr-2"></i>Fiches Passées
                        </a>
                        <a href="{{ route('deliveries.daily-sheet') }}" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm sm:text-base inline-flex items-center justify-center">
                            <i class="fas fa-file-pdf mr-2"></i>Fiche du Jour
                        </a>
                    </div>
                </div>

                <!-- Barre de recherche -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('deliveries.index') }}" class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1 relative">
                            <input type="text"
                                   name="search"
                                   value="{{ $query ?? '' }}"
                                   placeholder="Rechercher par adresse, statut, client, numéro de facture..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button type="submit" class="px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm sm:text-base inline-flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                        @if($query ?? false)
                            <a href="{{ route('deliveries.index') }}" class="px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-sm sm:text-base inline-flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>Effacer
                            </a>
                        @endif
                    </form>
                    @if($query ?? false)
                        <div class="mt-3 text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Résultats pour : <span class="font-semibold">"{{ $query }}"</span>
                            ({{ $deliveries->total() }} résultat{{ $deliveries->total() > 1 ? 's' : '' }})
                        </div>
                    @endif
                </div>

            <!-- Page Content -->
            <main class="p-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Livraison</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($deliveries as $delivery)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $delivery->order->invoice_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $delivery->order->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $delivery->delivery_address }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide shadow-sm
                                                    @if($delivery->status === 'En cours de livraison') bg-blue-500 text-white border border-blue-600
                                                    @elseif($delivery->status === 'Déjà payé mais non livré') bg-orange-500 text-white border border-orange-600
                                                    @elseif($delivery->status === 'Déjà payé et livré') bg-green-500 text-white border border-green-600
                                                    @elseif($delivery->status === 'Livré') bg-green-600 text-white border border-green-700
                                                    @elseif($delivery->status === 'Annulé') bg-red-500 text-white border border-red-600
                                                    @elseif($delivery->status === 'En cours de traitement') bg-purple-500 text-white border border-purple-600
                                                    @elseif($delivery->status === 'Retour mais déjà payé') bg-yellow-600 text-white border border-yellow-700
                                                    @elseif($delivery->status === 'Retour mais pas payé') bg-red-600 text-white border border-red-700
                                                    @else bg-gray-400 text-white border border-gray-500 @endif">
                                                    <i class="fas
                                                        @if($delivery->status === 'En cours de livraison') fa-truck
                                                        @elseif($delivery->status === 'Déjà payé mais non livré') fa-clock
                                                        @elseif($delivery->status === 'Déjà payé et livré') fa-check-double
                                                        @elseif($delivery->status === 'Livré') fa-check-circle
                                                        @elseif($delivery->status === 'Annulé') fa-times-circle
                                                        @elseif($delivery->status === 'En cours de traitement') fa-cogs
                                                        @elseif($delivery->status === 'Retour mais déjà payé') fa-undo
                                                        @elseif($delivery->status === 'Retour mais pas payé') fa-exclamation-triangle
                                                        @else fa-question-circle @endif mr-1.5"></i>
                                                    {{ $delivery->status }}
                                                </span>

                                                <!-- Changement de statut -->
                                                <div class="mt-2">
                                                    <form method="POST" action="{{ route('deliveries.updateStatus', $delivery) }}" class="inline">
                                                        @csrf
                                                        <select name="status" onchange="this.form.submit()" class="px-2 py-1 text-xs rounded border border-gray-300 focus:ring-1 focus:ring-indigo-500">
                                                            <option value="">Changer...</option>
                                                            <option value="En cours de livraison" {{ $delivery->status === 'En cours de livraison' ? 'selected' : '' }}>En cours de livraison</option>
                                                            <option value="Déjà payé mais non livré" {{ $delivery->status === 'Déjà payé mais non livré' ? 'selected' : '' }}>Déjà payé mais non livré</option>
                                                            <option value="Déjà payé et livré" {{ $delivery->status === 'Déjà payé et livré' ? 'selected' : '' }}>Déjà payé et livré</option>
                                                            <option value="Livré" {{ $delivery->status === 'Livré' ? 'selected' : '' }}>Livré</option>
                                                            <option value="Annulé" {{ $delivery->status === 'Annulé' ? 'selected' : '' }}>Annulé</option>
                                                            <option value="En cours de traitement" {{ $delivery->status === 'En cours de traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                                            <option value="Retour mais déjà payé" {{ $delivery->status === 'Retour mais déjà payé' ? 'selected' : '' }}>Retour mais déjà payé</option>
                                                            <option value="Retour mais pas payé" {{ $delivery->status === 'Retour mais pas payé' ? 'selected' : '' }}>Retour mais pas payé</option>
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $delivery->delivered_at ? $delivery->delivered_at->format('d/m/Y H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('orders.show', $delivery->order) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                    <i class="fas fa-eye mr-1"></i>Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $deliveries->links() }}
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
                setTimeout(() => {
                    nav.classList.remove('-translate-x-full');
                }, 10);
                document.body.style.overflow = 'hidden';
            } else {
                nav.classList.add('-translate-x-full');
                setTimeout(() => {
                    drawer.classList.add('hidden');
                }, 300);
                document.body.style.overflow = '';
            }
        }

        // Fonctionnalité de recherche améliorée
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const searchForm = document.querySelector('form[method="GET"]');

            if (searchInput && searchForm) {
                // Focus automatique sur la recherche au chargement
                searchInput.focus();

                // Recherche en temps réel (avec délai pour éviter trop de requêtes)
                let searchTimeout;
                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();

                    if (query.length >= 2 || query.length === 0) {
                        searchTimeout = setTimeout(() => {
                            searchForm.submit();
                        }, 500); // Délai de 500ms
                    }
                });

                // Raccourci clavier (Ctrl/Cmd + K) pour focus sur la recherche
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                });

                // Effacer la recherche avec la touche Escape
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && searchInput.value.trim()) {
                        window.location.href = '{{ route("deliveries.index") }}';
                    }
                });
            }
        });
    </script>
</body>
</html>
