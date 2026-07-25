<!-- Mobile Header -->
<header class="lg:hidden bg-gradient-to-r from-indigo-900 to-indigo-800 text-white p-4 shadow-lg">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="ml-3 text-xl font-bold flex items-center"><i class="fas fa-cube mr-2"></i> Kalmi Gestion</h1>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm">{{ now()->format('H:i') }}</span>
            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-sm">{{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'U' }}</div>
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
