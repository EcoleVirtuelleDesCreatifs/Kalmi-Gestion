<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modifier Commande - Kalmi Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-gradient-to-r from-indigo-900 to-indigo-800 text-white p-4 shadow-lg">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('orders.index') }}" class="p-2 rounded-lg hover:bg-indigo-700 transition mr-3">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <h1 class="text-xl font-bold flex items-center">
                        <i class="fas fa-cube mr-2"></i> Kalmi Gestion
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

        <main class="p-3 sm:p-4 lg:p-6 max-w-7xl mx-auto">
            <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-800">Modifier la commande</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $order->invoice_number }}</p>
                </div>
                <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center justify-center">
                    <i class="fas fa-eye mr-2"></i> Voir
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                    <p class="font-medium">{{ session('error') }}</p>
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

            <form method="POST" action="{{ route('orders.update', $order) }}" id="orderEditForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Customer -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user mr-2 text-indigo-600"></i> Informations Client
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du client <span class="text-gray-400">(facultatif)</span></label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" placeholder="Nom complet" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="tel" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" placeholder="0123456789" pattern="[0-9]{10}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Delivery -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-truck mr-2 text-indigo-600"></i> Livraison
                        </h3>
                        <div class="space-y-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="requiresDelivery" name="requires_delivery" value="1" {{ old('requires_delivery', $order->delivery ? 1 : 0) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 rounded">
                                <span class="font-medium text-gray-700">Demander une livraison</span>
                            </label>
                            <div id="deliveryAddressContainer" style="display: {{ old('requires_delivery', $order->delivery ? 1 : 0) ? 'block' : 'none' }};">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse de livraison</label>
                                <input type="text" id="deliveryAddress" name="delivery_address" value="{{ old('delivery_address', $order->delivery ? $order->delivery->delivery_address : '') }}" placeholder="Adresse de livraison" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-boxes mr-2 text-indigo-600"></i> Produits
                        </h3>
                        <button type="button" id="addProductBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                            <i class="fas fa-plus mr-2"></i> Ajouter un produit
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="productsTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix Unitaire</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->orderItems as $index => $item)
                                    <tr class="product-row" data-product-id="{{ $item->product_id }}" data-price="{{ $item->product->selling_price }}" data-stock="{{ $item->product->stock_quantity + $item->quantity }}">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                            {{ $item->product->name }} <span class="text-gray-500">(Stock max: {{ $item->product->stock_quantity + $item->quantity }})</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 price-cell">
                                            {{ number_format($item->product->selling_price, 2) }} FCFA
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <input type="number" name="items[{{ $index }}][quantity]" value="{{ old('items.'.$index.'.quantity', $item->quantity) }}" min="1" max="{{ $item->product->stock_quantity + $item->quantity }}" class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 quantity-input" required>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-800 total-cell">
                                            {{ number_format($item->unit_price * $item->quantity, 2) }} FCFA
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <button type="button" class="text-red-600 hover:text-red-900 remove-row">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-800">Total :</td>
                                    <td class="px-4 py-4 text-xl font-bold text-indigo-600" id="grandTotal">{{ number_format($order->total_amount, 2) }} FCFA</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 font-semibold text-lg shadow-lg transition">
                        <i class="fas fa-check mr-2"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('orders.index') }}" class="px-6 py-4 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold text-lg transition text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </main>
    </div>

    <template id="newProductRowTemplate">
        <tr class="product-row" data-price="0" data-stock="0">
            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                <select name="items[INDEX][product_id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 product-select" required>
                    <option value="">Choisir un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}" data-stock="{{ $product->stock_quantity }}">{{ $product->name }} - {{ number_format($product->selling_price, 2) }} FCFA (Stock: {{ $product->stock_quantity }})</option>
                    @endforeach
                </select>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 price-cell">0 FCFA</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm">
                <input type="number" name="items[INDEX][quantity]" value="1" min="1" class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 quantity-input" required>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-800 total-cell">0 FCFA</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm">
                <button type="button" class="text-red-600 hover:text-red-900 remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    </template>

    <script>
        const productsTable = document.getElementById('productsTable').querySelector('tbody');
        const template = document.getElementById('newProductRowTemplate');
        let rowIndex = {{ $order->orderItems->count() }};

        function formatMoney(value) {
            return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' FCFA';
        }

        function updateRowTotal(row) {
            const price = parseFloat(row.dataset.price) || 0;
            const qtyInput = row.querySelector('.quantity-input');
            const qty = parseInt(qtyInput.value) || 0;
            row.querySelector('.total-cell').textContent = formatMoney(price * qty);
        }

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const price = parseFloat(row.dataset.price) || 0;
                const qty = parseInt(row.querySelector('.quantity-input').value) || 0;
                total += price * qty;
            });
            document.getElementById('grandTotal').textContent = formatMoney(total);
        }

        function attachRowEvents(row) {
            const qtyInput = row.querySelector('.quantity-input');
            const select = row.querySelector('.product-select');
            const removeBtn = row.querySelector('.remove-row');

            qtyInput.addEventListener('input', function() {
                const stock = parseInt(row.dataset.stock) || 0;
                const max = parseInt(this.max) || 999999;
                let val = parseInt(this.value) || 1;
                if (val < 1) val = 1;
                if (val > max) {
                    val = max;
                    this.value = val;
                }
                updateRowTotal(row);
                updateGrandTotal();
            });

            if (select) {
                select.addEventListener('change', function() {
                    const option = this.options[this.selectedIndex];
                    const price = parseFloat(option.dataset.price) || 0;
                    const stock = parseInt(option.dataset.stock) || 0;
                    row.dataset.price = price;
                    row.dataset.stock = stock;
                    row.querySelector('.price-cell').textContent = formatMoney(price);
                    const qtyInput = row.querySelector('.quantity-input');
                    qtyInput.max = stock;
                    qtyInput.value = 1;
                    updateRowTotal(row);
                    updateGrandTotal();
                });
            }

            removeBtn.addEventListener('click', function() {
                row.remove();
                updateGrandTotal();
            });
        }

        document.querySelectorAll('.product-row').forEach(row => attachRowEvents(row));

        document.getElementById('addProductBtn').addEventListener('click', function() {
            const html = template.innerHTML.replace(/INDEX/g, rowIndex);
            const temp = document.createElement('tbody');
            temp.innerHTML = html;
            const newRow = temp.firstElementChild;
            productsTable.appendChild(newRow);
            attachRowEvents(newRow);
            rowIndex++;
        });

        document.getElementById('requiresDelivery').addEventListener('change', function() {
            document.getElementById('deliveryAddressContainer').style.display = this.checked ? 'block' : 'none';
            if (!this.checked) document.getElementById('deliveryAddress').value = '';
        });
    </script>
@include('components.loading')
</body>
</html>
