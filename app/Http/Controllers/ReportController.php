<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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

        return view('reports.index', compact(
            'period',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalProfit',
            'totalOrders',
            'averageOrderValue',
            'orders'
        ));
    }
}
