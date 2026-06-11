<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouvelle Vente - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <i class="fas fa-home w-5 mr-3"></i>
                            Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('orders.create') }}"
                               class="flex items-center px-4 py-3 rounded-lg bg-indigo-700">
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

                    @if(auth()->user()->role === 'admin')
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
                    <h2 class="text-2xl font-bold text-gray-800">Nouvelle Vente</h2>
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
                    <h2 class="text-lg font-bold text-gray-800">Nouvelle Vente</h2>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 sm:p-4 lg:p-6">
                <div class="mb-4 sm:mb-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Nouvelle Vente</h2>
                    <p class="text-sm text-gray-600 mt-1">Créer une nouvelle commande client</p>
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

                <div x-data="orderForm" class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Cart Section -->
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4 z-40 border-2 border-indigo-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center bg-gradient-to-r from-indigo-50 to-purple-50 p-3 rounded-lg -m-3">
                            <i class="fas fa-shopping-basket mr-2 text-indigo-600"></i>
                            Panier
                            <span x-show="cart.length > 0" x-text="cart.length" class="ml-auto bg-indigo-600 text-white text-xs px-2 py-1 rounded-full"></span>
                        </h3>

                        <div x-show="cart.length === 0" class="text-center py-12 text-gray-500">
                            <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                            <p>Le panier est vide</p>
                        </div>

                        <div x-show="cart.length > 0" class="space-y-3">
                            <template x-for="(item, index) in cart" :key="item.id">
                                <div class="flex items-center justify-between p-4 border-2 border-indigo-200 rounded-lg bg-gradient-to-r from-indigo-50 to-white shadow-sm">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800" x-text="item.name"></h4>
                                        <p class="text-sm text-gray-600">
                                            <span x-text="item.quantity"></span> x
                                            <span x-text="item.price.toFixed(2)"></span> FCFA =
                                            <span class="font-semibold" x-text="(item.quantity * item.price).toFixed(2)"></span> FCFA
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="updateQuantity(index, -1)"
                                                class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300 transition">-</button>
                                        <span x-text="item.quantity" class="w-8 text-center font-medium"></span>
                                        <button @click="updateQuantity(index, 1)"
                                                class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300 transition">+</button>
                                        <button @click="removeFromCart(index)"
                                                class="w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Total -->
                            <div class="border-t-2 border-indigo-200 pt-4 mt-4 bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-lg -mx-2">
                                <div class="flex justify-between text-2xl font-bold text-gray-800">
                                    <span>Total:</span>
                                    <span class="text-indigo-600" x-text="getTotal().toFixed(2) + ' FCFA'"></span>
                                </div>
                            </div>

                            <!-- Delivery Options -->
                            <div class="mt-4 p-4 border border-gray-200 rounded-lg">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" x-model="requiresDelivery" class="w-5 h-5 text-indigo-600 rounded">
                                    <span class="font-medium text-gray-700">Demander une livraison</span>
                                </label>
                                <div x-show="requiresDelivery" class="mt-3">
                                    <input type="text"
                                           x-model="deliveryAddress"
                                           placeholder="Adresse de livraison"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <form method="POST" action="{{ route('orders.store') }}" x-data="{ formData: {} }" @submit="prepareFormData">
                                @csrf
                                <input type="hidden" name="requires_delivery" :value="requiresDelivery ? 1 : 0">
                                <input type="hidden" name="delivery_address" :value="deliveryAddress">

                                <!-- Customer Information -->
                                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <i class="fas fa-user mr-2 text-indigo-600"></i>
                                        Informations Client
                                    </h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Nom du client <span class="text-gray-400">(facultatif)</span>
                                            </label>
                                            <input type="text"
                                                   name="customer_name"
                                                   placeholder="Nom complet du client"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Téléphone du client
                                            </label>
                                            <input type="tel"
                                                   name="customer_phone"
                                                   required
                                                   placeholder="Ex: 0123456789"
                                                   pattern="[0-9]{10}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                        :disabled="cart.length === 0"
                                        class="w-full mt-4 px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed font-semibold transition text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-check mr-2"></i>Valider la Commande
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Products Section -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-boxes mr-2 text-indigo-600"></i>
                            Produits
                        </h3>

                        <!-- Search -->
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text"
                                       x-model="searchQuery"
                                       placeholder="Rechercher un produit..."
                                       class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Products List -->
                        <div class="space-y-3 max-h-[600px] overflow-y-auto">
                            @foreach($products as $product)
                                <div x-show="('{{ $product->name }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                                           '{{ $product->category->name ?? '' }}'.toLowerCase().includes(searchQuery.toLowerCase()))"
                                     class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800">{{ $product->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Sans catégorie' }}</p>
                                        <div class="flex items-center gap-4 mt-1">
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-money-bill-wave mr-1"></i>{{ number_format($product->selling_price, 2) }} FCFA
                                            </p>
                                            <p class="text-sm {{ $product->stock_quantity <= $product->alert_threshold ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                                <i class="fas fa-box mr-1"></i>Stock: {{ $product->stock_quantity }}
                                            </p>
                                        </div>
                                    </div>
                                    <button @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->selling_price }}, {{ $product->stock_quantity }})"
                                            :disabled="{{ $product->stock_quantity }} <= getCartQuantity({{ $product->id }})"
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                                        <i class="fas fa-plus mr-1"></i>Ajouter
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderForm', () => ({
                cart: [],
                searchQuery: '',
                deliveryAddress: '',
                requiresDelivery: false,

                addToCart(productId, name, price, stock) {
                    const existingItem = this.cart.find(item => item.product_id === productId);
                    const currentQuantity = existingItem ? existingItem.quantity : 0;

                    if (currentQuantity < stock) {
                        if (existingItem) {
                            existingItem.quantity++;
                        } else {
                            this.cart.push({
                                product_id: productId,
                                name: name,
                                price: price,
                                quantity: 1,
                                maxStock: stock
                            });
                        }
                    }
                },

                getCartQuantity(productId) {
                    const item = this.cart.find(item => item.product_id === productId);
                    return item ? item.quantity : 0;
                },

                updateQuantity(index, change) {
                    const item = this.cart[index];
                    const newQuantity = item.quantity + change;

                    if (newQuantity > 0 && newQuantity <= item.maxStock) {
                        item.quantity = newQuantity;
                    } else if (newQuantity <= 0) {
                        this.cart.splice(index, 1);
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                getTotal() {
                    return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                },

                prepareFormData(event) {
                    const form = event.target;

                    // Supprimer les anciens items s'ils existent
                    const existingItems = form.querySelectorAll('input[name^="items["]');
                    existingItems.forEach(input => input.remove());

                    // Ajouter les items du panier au formulaire
                    this.cart.forEach((item, index) => {
                        const productIdInput = document.createElement('input');
                        productIdInput.type = 'hidden';
                        productIdInput.name = `items[${index}][product_id]`;
                        productIdInput.value = item.product_id;
                        form.appendChild(productIdInput);

                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'hidden';
                        quantityInput.name = `items[${index}][quantity]`;
                        quantityInput.value = item.quantity;
                        form.appendChild(quantityInput);
                    });

                    // Laisser le formulaire se soumettre normalement
                    // La soumission standard préservera les messages flash
                }
            }))
        })
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
</body>
</html>
