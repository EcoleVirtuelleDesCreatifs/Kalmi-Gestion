<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-800 text-white fixed h-full overflow-y-auto">
        <div class="p-6">
            <h1 class="text-2xl font-bold">Kalmi Gestion</h1>
        </div>
        
        <nav class="mt-6">
            <ul class="space-y-2 px-4">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                
                @if(auth()->user()->role === 'vendeur' || auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('orders.create') }}" 
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('orders.create') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Nouvelle Vente
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('orders.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Commandes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('deliveries.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('deliveries.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                            Livraisons
                        </a>
                    </li>
                @endif
                
                @if(auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('categories.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('categories.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Catégories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('products.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Produits
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('reports.index') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Rapports
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        
        <!-- User Info -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-indigo-700">
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
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h2>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-gray-900">
                        Profil
                    </a>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>
