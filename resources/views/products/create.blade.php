<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouveau Produit - Kalmi Gestion</title>
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
                               class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-truck w-5 mr-3"></i>
                                Livraisons
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
                               class="flex items-center px-4 py-3 rounded-lg bg-indigo-700">
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
                    <h2 class="text-2xl font-bold text-gray-800">Nouveau Produit</h2>
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
                    <h2 class="text-lg font-bold text-gray-800">Nouveau Produit</h2>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 sm:p-4 lg:p-6">
                <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Nouveau Produit</h2>
                        <p class="text-sm text-gray-600 mt-1">Ajouter un nouveau produit au catalogue</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm sm:text-base">
                        <i class="fas fa-arrow-left mr-2"></i>Retour
                    </a>
                </div>

            <!-- Page Content -->
            <main class="p-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <form method="POST" action="{{ route('products.store') }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-tags mr-2 text-indigo-600"></i>Catégorie
                                    </label>
                                    <select name="category_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-box mr-2 text-indigo-600"></i>Nom
                                    </label>
                                    <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-money-bill-wave mr-2 text-indigo-600"></i>Prix d'achat (FCFA)
                                    </label>
                                    <input type="number" step="0.01" name="purchase_price" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-money-bill-wave mr-2 text-indigo-600"></i>Prix de vente (FCFA)
                                    </label>
                                    <input type="number" step="0.01" name="selling_price" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-warehouse mr-2 text-indigo-600"></i>Quantité en stock
                                    </label>
                                    <input type="number" name="stock_quantity" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-bell mr-2 text-indigo-600"></i>Seuil d'alerte
                                    </label>
                                    <input type="number" name="alert_threshold" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="mt-6 flex gap-4">
                                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                                    <i class="fas fa-save mr-2"></i>Créer
                                </button>
                                <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                                    <i class="fas fa-times mr-2"></i>Annuler
                                </a>
                            </div>
                        </form>
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
    </script>
</body>
</html>
