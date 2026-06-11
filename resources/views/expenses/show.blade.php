<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détails Dépense - Kalmi Gestion</title>
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

                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                Tableau de bord
                            </a>
                        </li>
                        @if(auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                    <i class="fas fa-shopping-cart w-5 mr-3"></i>
                                    Ventes
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('deliveries.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                    <i class="fas fa-truck w-5 mr-3"></i>
                                    Livraisons
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-3 rounded-lg bg-indigo-700 transition">
                                    <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                                    Dépenses
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                    <i class="fas fa-box w-5 mr-3"></i>
                                    Produits
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                    <i class="fas fa-tags w-5 mr-3"></i>
                                    Catégories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
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

            <nav class="flex-1 px-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                            Tableau de bord
                        </a>
                    </li>
                    @if(auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-shopping-cart w-5 mr-3"></i>
                                Ventes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('deliveries.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-truck w-5 mr-3"></i>
                                Livraisons
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-3 rounded-lg bg-indigo-700 transition">
                                <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                                Dépenses
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-box w-5 mr-3"></i>
                                Produits
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-tags w-5 mr-3"></i>
                                Catégories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-chart-bar w-5 mr-3"></i>
                                Rapports
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

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
                    <h2 class="text-2xl font-bold text-gray-800">Détails de la dépense</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ now()->format('d/m/Y H:i') }}</span>
                        <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 sm:p-4 lg:p-6">
                <!-- Navigation -->
                <div class="mb-6 flex items-center space-x-2 text-sm">
                    <a href="{{ route('expenses.index') }}" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-arrow-left mr-1"></i>Retour aux dépenses
                    </a>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Détails de la dépense</h2>
                                <p class="text-gray-600">Informations complètes sur la dépense sélectionnée</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations générales</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm text-gray-500">Description</span>
                                            <p class="font-medium">{{ $expense->description }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Montant</span>
                                            <p class="text-2xl font-bold text-red-600">{{ number_format($expense->amount, 2, ',', ' ') }} FCFA</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Catégorie</span>
                                            <p><span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">{{ $expense->category }}</span></p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Date de la dépense</span>
                                            <p class="font-medium">{{ $expense->expense_date->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations supplémentaires</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm text-gray-500">Numéro de reçu</span>
                                            <p class="font-medium">{{ $expense->receipt_number ?? 'Non spécifié' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Notes</span>
                                            <p class="font-medium">{{ $expense->notes ?? 'Aucune note' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Enregistré par</span>
                                            <p class="font-medium">{{ $expense->user->name }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Date d'enregistrement</span>
                                            <p class="font-medium">{{ $expense->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center">
                                        <i class="fas fa-edit mr-2"></i>Modifier
                                    </a>
                                    <a href="{{ route('expenses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition inline-flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i>Retour
                                    </a>
                                </div>
                            </div>
                        </div>
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
