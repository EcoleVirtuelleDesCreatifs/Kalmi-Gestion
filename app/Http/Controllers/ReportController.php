<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\Selling;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');

        switch ($period) {
            case 'daily':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
        }

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with('orderItems')
            ->get();

        $totalRevenue = $orders->sum('total_amount');

        $totalProfit = 0;
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $itemProfit = ($item->unit_price - $item->purchase_price_snap) * $item->quantity;
                $totalProfit += $itemProfit;
            }
        }

        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $totalSellings = Selling::whereBetween('selling_date', [$startDate, $endDate])->sum('amount');
        $totalSellingsCount = Selling::whereBetween('selling_date', [$startDate, $endDate])->count();

        $totalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');
        $totalDeliveries = Delivery::whereBetween('created_at', [$startDate, $endDate])->count();

        $netProfit = $totalProfit - $totalExpenses;
        $totalProducts = Product::count();

        // Recent data for tables
        $recentOrders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentSellings = Selling::with('user')
            ->whereBetween('selling_date', [$startDate, $endDate])
            ->orderBy('selling_date', 'desc')
            ->take(10)
            ->get();

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock_quantity', '<=', 'alert_threshold')
            ->get();

        // Sales by category
        $salesByCategory = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.quantity * order_items.unit_price) as total_revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_qty')
            ->get();

        // Top products
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.quantity * order_items.unit_price) as total_revenue'),
                DB::raw('SUM(order_items.quantity * (order_items.unit_price - order_items.purchase_price_snap)) as total_profit')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->take(10)
            ->get();

        // Revenue & profit chart data
        $chartOrders = Order::whereBetween('created_at', [$startDate, $endDate])->with('orderItems')->get();

        if ($period === 'daily') {
            $revenueData = array_fill(0, 24, 0);
            $profitData = array_fill(0, 24, 0);
            foreach ($chartOrders as $order) {
                $h = (int) $order->created_at->format('G');
                $revenueData[$h] += $order->total_amount;
                foreach ($order->orderItems as $item) {
                    $profitData[$h] += ($item->unit_price - $item->purchase_price_snap) * $item->quantity;
                }
            }
            $chartLabels = array_map(fn($h) => sprintf('%02d:00', $h), range(0, 23));
        } elseif ($period === 'monthly') {
            $daysCount = $endDate->day;
            $revenueData = array_fill(1, $daysCount, 0);
            $profitData = array_fill(1, $daysCount, 0);
            foreach ($chartOrders as $order) {
                $d = (int) $order->created_at->format('j');
                $revenueData[$d] += $order->total_amount;
                foreach ($order->orderItems as $item) {
                    $profitData[$d] += ($item->unit_price - $item->purchase_price_snap) * $item->quantity;
                }
            }
            $chartLabels = range(1, $daysCount);
            $revenueData = array_values($revenueData);
            $profitData = array_values($profitData);
        } else {
            $revenueData = array_fill(1, 12, 0);
            $profitData = array_fill(1, 12, 0);
            foreach ($chartOrders as $order) {
                $m = (int) $order->created_at->format('n');
                $revenueData[$m] += $order->total_amount;
                foreach ($order->orderItems as $item) {
                    $profitData[$m] += ($item->unit_price - $item->purchase_price_snap) * $item->quantity;
                }
            }
            $chartLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            $revenueData = array_values($revenueData);
            $profitData = array_values($profitData);
        }

        return view('reports.index', compact(
            'period',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalProfit',
            'totalOrders',
            'averageOrderValue',
            'orders',
            'totalSellings',
            'totalSellingsCount',
            'totalExpenses',
            'totalDeliveries',
            'netProfit',
            'totalProducts',
            'recentOrders',
            'recentSellings',
            'lowStockProducts',
            'salesByCategory',
            'topProducts',
            'chartLabels',
            'revenueData',
            'profitData'
        ));
    }

    public function dashboard()
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with('orderItems')
            ->get();

        $totalRevenue = $orders->sum('total_amount');

        $totalProfit = 0;
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $itemProfit = ($item->unit_price - $item->purchase_price_snap) * $item->quantity;
                $totalProfit += $itemProfit;
            }
        }

        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $totalSellings = Selling::whereBetween('selling_date', [$startDate, $endDate])->sum('amount');
        $totalSellingsCount = Selling::whereBetween('selling_date', [$startDate, $endDate])->count();

        $totalDeliveries = Delivery::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');

        return view('dashboard', compact(
            'totalRevenue',
            'totalProfit',
            'totalOrders',
            'averageOrderValue',
            'totalSellings',
            'totalSellingsCount',
            'totalDeliveries',
            'totalExpenses'
        ));
    }
}
