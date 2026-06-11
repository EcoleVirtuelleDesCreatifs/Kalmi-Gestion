<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détails Commande - Kalmi Gestion</title>
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
                               class="flex items-center px-4 py-3 rounded-lg bg-indigo-700">
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
                    <h2 class="text-2xl font-bold text-gray-800">Détails Commande</h2>
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
                    <h2 class="text-lg font-bold text-gray-800">Détails Commande</h2>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 sm:p-4 lg:p-6">
                <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Détails Commande</h2>
                        <p class="text-sm text-gray-600 mt-1">Informations détaillées de la commande</p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm sm:text-base">
                        <i class="fas fa-arrow-left mr-2"></i>Retour
                    </a>
                </div>

            <!-- Page Content -->
            <main class="p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-3 text-xl"></i>
                        <div>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                        <div>
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                        <div>
                            <p class="font-medium">Veuillez corriger les erreurs suivantes :</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <!-- Order Header -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Facture #{{ $order->invoice_number }}</h3>
                                    <div class="mt-2 space-y-1">
                                        <p class="text-gray-600"><i class="fas fa-user mr-2"></i>Vendeur: {{ $order->user->name }}</p>
                                        @if($order->customer_name)
                                            <p class="text-gray-600"><i class="fas fa-user-tag mr-2"></i>Client: {{ $order->customer_name }}</p>
                                        @endif
                                        @if($order->customer_phone)
                                            <p class="text-gray-600"><i class="fas fa-phone mr-2"></i>Téléphone: {{ $order->customer_phone }}</p>
                                        @endif
                                        <p class="text-gray-600"><i class="fas fa-calendar mr-2"></i>Date: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold text-indigo-600">{{ number_format($order->total_amount, 2) }} FCFA</p>
                                    <p class="text-gray-500">Total</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->orderItems as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item->unit_price, 2) }} FCFA</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">{{ number_format($item->unit_price * $item->quantity, 2) }} FCFA</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Delivery Info -->
                        @if($order->delivery)
                            <div class="border-t pt-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-truck mr-2 text-indigo-600"></i>
                                    Informations de Livraison
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600 mb-2">Statut actuel:</p>
                                        @if($order->delivery)
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide shadow-lg transform hover:scale-105 transition-all duration-200
                                                @if($order->delivery->status === 'En cours de livraison') bg-gradient-to-r from-blue-400 to-blue-600 text-white border-2 border-blue-300
                                                @elseif($order->delivery->status === 'Déjà payé mais non livré') bg-gradient-to-r from-amber-400 to-orange-600 text-white border-2 border-amber-300
                                                @elseif($order->delivery->status === 'Déjà payé et livré') bg-gradient-to-r from-emerald-400 to-green-600 text-white border-2 border-emerald-300
                                                @elseif($order->delivery->status === 'Livré') bg-gradient-to-r from-green-500 to-green-700 text-white border-2 border-green-400
                                                @elseif($order->delivery->status === 'Annulé') bg-gradient-to-r from-red-400 to-red-600 text-white border-2 border-red-300
                                                @elseif($order->delivery->status === 'En cours de traitement') bg-gradient-to-r from-purple-400 to-purple-600 text-white border-2 border-purple-300
                                                @elseif($order->delivery->status === 'Retour mais déjà payé') bg-gradient-to-r from-yellow-400 to-yellow-600 text-white border-2 border-yellow-300
                                                @elseif($order->delivery->status === 'Retour mais pas payé') bg-gradient-to-r from-rose-500 to-red-700 text-white border-2 border-rose-400
                                                @else bg-gradient-to-r from-gray-400 to-gray-600 text-white border-2 border-gray-300 @endif">
                                                <i class="fas
                                                    @if($order->delivery->status === 'En cours de livraison') fa-truck
                                                    @elseif($order->delivery->status === 'Déjà payé mais non livré') fa-clock
                                                    @elseif($order->delivery->status === 'Déjà payé et livré') fa-check-double
                                                    @elseif($order->delivery->status === 'Livré') fa-check-circle
                                                    @elseif($order->delivery->status === 'Annulé') fa-times-circle
                                                    @elseif($order->delivery->status === 'En cours de traitement') fa-cogs
                                                    @elseif($order->delivery->status === 'Retour mais déjà payé') fa-undo
                                                    @elseif($order->delivery->status === 'Retour mais pas payé') fa-exclamation-triangle
                                                    @else fa-question-circle @endif mr-1.5"></i>
                                                {{ $order->delivery->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-200 text-gray-600 border border-gray-300">
                                                <i class="fas fa-minus-circle mr-1.5"></i>
                                                Non défini
                                            </span>
                                        @endif

                                        <p class="text-sm text-gray-600 mb-2 mt-4">Changer le statut:</p>
                                        <form method="POST" action="{{ route('deliveries.updateStatus', $order->delivery) }}">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                                <option value="En cours de livraison" {{ $order->delivery->status === 'En cours de livraison' ? 'selected' : '' }}>En cours de livraison</option>
                                                <option value="Déjà payé mais non livré" {{ $order->delivery->status === 'Déjà payé mais non livré' ? 'selected' : '' }}>Déjà payé mais non livré</option>
                                                <option value="Déjà payé et livré" {{ $order->delivery->status === 'Déjà payé et livré' ? 'selected' : '' }}>Déjà payé et livré</option>
                                                <option value="Livré" {{ $order->delivery->status === 'Livré' ? 'selected' : '' }}>Livré</option>
                                                <option value="Annulé" {{ $order->delivery->status === 'Annulé' ? 'selected' : '' }}>Annulé</option>
                                                <option value="En cours de traitement" {{ $order->delivery->status === 'En cours de traitement' ? 'selected' : '' }}>En cours de traitement</option>
                                                <option value="Retour mais déjà payé" {{ $order->delivery->status === 'Retour mais déjà payé' ? 'selected' : '' }}>Retour mais déjà payé</option>
                                                <option value="Retour mais pas payé" {{ $order->delivery->status === 'Retour mais pas payé' ? 'selected' : '' }}>Retour mais pas payé</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600 mb-2">Adresse:</p>
                                        <p class="font-medium text-gray-800">{{ $order->delivery->delivery_address }}</p>
                                    </div>
                                    @if($order->delivery->delivered_at)
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm text-gray-600 mb-2">Livré le:</p>
                                            <p class="font-medium text-gray-800">{{ $order->delivery->delivered_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    @endif
                                </div>
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
