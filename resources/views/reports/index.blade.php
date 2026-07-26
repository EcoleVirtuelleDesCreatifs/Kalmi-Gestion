<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rapports - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Navigation Drawer -->
        <div id="mobileMenuDrawer" class="lg:hidden fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
            <nav class="absolute left-0 top-0 h-full w-72 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white shadow-xl transform transition-transform duration-300"
                id="mobileMenuNav">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold flex items-center">
                            <i class="fas fa-cube mr-2"></i>
                            Menu
                        </h2>
                        <button onclick="toggleMobileMenu()" type="button"
                            class="p-2 rounded-lg hover:bg-indigo-700 transition-colors focus:outline-none">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <!-- User Info Mobile -->
                    <div class="mb-6 p-4 bg-indigo-800 rounded-lg">
                        <div class="flex items-center">
                            <div
                                class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-lg">
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
                                <a href="{{ route('sellings.index') }}"
                                    class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('sellings.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                    <i class="fas fa-cash-register w-5 mr-3"></i>
                                    Selling
                                </a>
                            </li>
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

            <nav class="mt-6 flex-1">
                <ul class="space-y-2 px-4">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <i class="fas fa-home w-5 mr-3"></i>
                            Dashboard
                        </a>
                    </li>

                    @if (auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('sellings.index') }}"
                                class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('sellings.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                                <i class="fas fa-cash-register w-5 mr-3"></i>
                                Selling
                            </a>
                        </li>
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
                    <button type="submit"
                        class="w-full px-4 py-2 bg-indigo-700 rounded-lg hover:bg-indigo-600 transition text-sm">
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
                    <h2 class="text-2xl font-bold text-gray-800">Rapports</h2>
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
                    <h2 class="text-lg font-bold text-gray-800">Rapports</h2>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 sm:p-4 lg:p-6">
                <!-- Period Selector -->
                <div class="mb-4 sm:mb-6">
                    <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                        <a href="{{ route('reports.index', ['period' => 'daily']) }}"
                            class="px-3 py-2 sm:px-4 rounded-lg text-sm sm:text-base {{ $period === 'daily' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow">
                            <i class="fas fa-calendar-day mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Journalier</span>
                            <span class="sm:hidden">Jour</span>
                        </a>
                        <a href="{{ route('reports.index', ['period' => 'monthly']) }}"
                            class="px-3 py-2 sm:px-4 rounded-lg text-sm sm:text-base {{ $period === 'monthly' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow">
                            <i class="fas fa-calendar-alt mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Mensuel</span>
                            <span class="sm:hidden">Mois</span>
                        </a>
                        <a href="{{ route('reports.index', ['period' => 'yearly']) }}"
                            class="px-3 py-2 sm:px-4 rounded-lg text-sm sm:text-base {{ $period === 'yearly' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow">
                            <i class="fas fa-calendar mr-1 sm:mr-2"></i>
                            <span class="hidden sm:inline">Annuel</span>
                            <span class="sm:hidden">An</span>
                        </a>
                    </div>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-500 text-xs sm:text-sm font-medium">Chiffre d'Affaires</p>
                                <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mt-1 lg:mt-2">
                                    {{ number_format($totalRevenue, 2) }} FCFA</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
                            </div>
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-full flex items-center justify-center ml-2 lg:ml-4">
                                <i class="fas fa-money-bill-wave text-blue-600 text-lg lg:text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-500 text-xs sm:text-sm font-medium">Bénéfice Brut</p>
                                <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mt-1 lg:mt-2">
                                    {{ number_format($totalProfit, 2) }} FCFA</p>
                                <p class="text-xs text-gray-400 mt-1">Marge sur ventes</p>
                            </div>
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-green-100 rounded-full flex items-center justify-center ml-2 lg:ml-4">
                                <i class="fas fa-chart-line text-green-600 text-lg lg:text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6 border-l-4 border-red-500">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-500 text-xs sm:text-sm font-medium">Dépenses</p>
                                <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mt-1 lg:mt-2">
                                    {{ number_format($totalExpenses, 2) }} FCFA</p>
                                <p class="text-xs text-gray-400 mt-1">Période</p>
                            </div>
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-red-100 rounded-full flex items-center justify-center ml-2 lg:ml-4">
                                <i class="fas fa-money-bill-wave text-red-600 text-lg lg:text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6 border-l-4 border-pink-500">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-500 text-xs sm:text-sm font-medium">Selling</p>
                                <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mt-1 lg:mt-2">
                                    {{ number_format($totalSellings, 2) }} FCFA</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $totalSellingsCount }} ventes</p>
                            </div>
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-pink-100 rounded-full flex items-center justify-center ml-2 lg:ml-4">
                                <i class="fas fa-cash-register text-pink-600 text-lg lg:text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-4 lg:p-6 border-l-4 border-emerald-500">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-500 text-xs sm:text-sm font-medium">Bénéfice Net</p>
                                <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mt-1 lg:mt-2">
                                    {{ number_format($netProfit, 2) }} FCFA</p>
                                <p class="text-xs text-gray-400 mt-1">Après dépenses</p>
                            </div>
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 rounded-full flex items-center justify-center ml-2 lg:ml-4">
                                <i class="fas fa-coins text-emerald-600 text-lg lg:text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue & Category Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Évolution du Chiffre d'Affaires et du Bénéfice</h3>
                        <div class="relative h-72">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ventes par Catégorie</h3>
                        <div class="relative h-72">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders & Sellings -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-lg p-6 overflow-x-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Commandes Récentes</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @if ($recentOrders->count() > 0)
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $order->invoice_number }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $order->user->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-right font-medium">{{ number_format($order->total_amount, 2) }} FCFA</td>
                                            <td class="px-4 py-2 text-sm text-right text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucune commande</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 overflow-x-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ventes Selling Récentes</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @if ($recentSellings->count() > 0)
                                    @foreach ($recentSellings as $selling)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $selling->user->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-right font-medium">{{ number_format($selling->amount, 2) }} FCFA</td>
                                            <td class="px-4 py-2 text-sm text-right text-gray-400">{{ $selling->selling_date ? $selling->selling_date->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">Aucune vente</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Expenses -->
                <div class="bg-white rounded-xl shadow-lg p-6 overflow-x-auto mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-money-bill-wave text-red-500 mr-2"></i>Dépenses Récentes
                    </h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @if ($recentExpenses->count() > 0)
                                @foreach ($recentExpenses as $expense)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $expense->description }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $expense->category }}</td>
                                        <td class="px-4 py-2 text-sm text-right font-medium">{{ number_format($expense->amount, 2) }} FCFA</td>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $expense->user->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="px-4 py-4 text-center text-gray-500">Aucune dépense pour cette période</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Top Products & Alerts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-lg p-6 overflow-x-auto">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Produits</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Qté</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">CA</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Bénéfice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @if ($topProducts->count() > 0)
                                    @foreach ($topProducts as $product)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $product->name }}</td>
                                            <td class="px-4 py-2 text-sm text-right">{{ number_format($product->total_qty) }}</td>
                                            <td class="px-4 py-2 text-sm text-right font-medium">{{ number_format($product->total_revenue, 2) }} FCFA</td>
                                            <td class="px-4 py-2 text-sm text-right font-medium">{{ number_format($product->total_profit, 2) }} FCFA</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucune vente</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if (auth()->user()->role === 'admin')
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Alertes de Stock
                            </h3>
                            @if ($lowStockProducts->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($lowStockProducts as $product)
                                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Sans catégorie' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-red-600">{{ $product->stock_quantity }}</p>
                                                <p class="text-xs text-gray-400">Seuil: {{ $product->alert_threshold }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">Aucune alerte de stock</p>
                            @endif
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        // Revenue & Profit Chart
        const revCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Chiffre d\'affaires',
                        data: @json($revenueData),
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Bénéfice',
                        data: @json($profitData),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Category Chart
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: @json($salesByCategory->pluck('name')),
                datasets: [{
                    data: @json($salesByCategory->pluck('total_revenue')),
                    backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>

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
@include('components.loading')
</body>

</html>
