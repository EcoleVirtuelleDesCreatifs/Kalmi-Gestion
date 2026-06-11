<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $orders = Order::with(['user', 'orderItems.product', 'delivery'])
            ->when($query, function($q) use ($query) {
                $q->where(function($subQuery) use ($query) {
                    $subQuery->where('invoice_number', 'like', "%{$query}%")
                            ->orWhere('customer_name', 'like', "%{$query}%")
                            ->orWhere('customer_phone', 'like', "%{$query}%")
                            ->orWhereHas('user', function($userQuery) use ($query) {
                                $userQuery->where('name', 'like', "%{$query}%");
                            })
                            ->orWhereHas('orderItems.product', function($productQuery) use ($query) {
                                $productQuery->where('name', 'like', "%{$query}%");
                            });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('orders.index', compact('orders', 'query'));
    }

    public function create()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'required|string|regex:/^[0-9]{10}$/',
            'delivery_address' => 'nullable|string',
            'requires_delivery' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    DB::rollBack();
                    return back()->with('error', 'Produit non trouvé');
                }

                if ($product->stock_quantity < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', "Stock insuffisant pour {$product->name}. Disponible: {$product->stock_quantity}, Demandé: {$item['quantity']}");
                }

                $unitPrice = $product->selling_price;
                $itemTotal = $unitPrice * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'purchase_price_snap' => $product->purchase_price,
                ];

                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }

            $invoiceNumber = 'INV-' . date('Ymd-His') . '-' . Auth::id();

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'invoice_number' => $invoiceNumber,
                'total_amount' => $totalAmount,
            ]);

            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            if ($request->requires_delivery && $request->delivery_address) {
                $order->delivery()->create([
                    'status' => 'en_attente',
                    'delivery_address' => $request->delivery_address,
                ]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Commande créée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création de la commande: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'delivery']);

        return view('orders.show', compact('order'));
    }

    public function exportPDF()
    {
        $orders = Order::with(['user', 'orderItems.product', 'delivery'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('orders.pdf', compact('orders'));

        return $pdf->download('commandes_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportCSV()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'commandes_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'Numéro Facture',
                'Date',
                'Vendeur',
                'Client',
                'Téléphone',
                'Montant Total',
                'Produits',
                'Statut Livraison'
            ]);

            // Données
            foreach ($orders as $order) {
                $products = $order->orderItems->map(function($item) {
                    return $item->product->name . ' (' . $item->quantity . ')';
                })->implode(', ');

                fputcsv($file, [
                    $order->invoice_number,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->user->name,
                    $order->customer_name ?? 'Non spécifié',
                    $order->customer_phone ?? 'Non spécifié',
                    number_format($order->total_amount, 2) . ' FCFA',
                    $products,
                    $order->delivery ? $order->delivery->status : 'Non livré'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
