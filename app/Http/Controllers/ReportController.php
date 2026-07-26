<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Selling;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'netProfit'
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
