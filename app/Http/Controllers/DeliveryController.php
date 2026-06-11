<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $deliveries = Delivery::with(['order.user', 'order.orderItems.product'])
            ->when($query, function($q) use ($query) {
                $q->where(function($subQuery) use ($query) {
                    $subQuery->where('delivery_address', 'like', "%{$query}%")
                            ->orWhere('status', 'like', "%{$query}%")
                            ->orWhereHas('order', function($orderQuery) use ($query) {
                                $orderQuery->where('invoice_number', 'like', "%{$query}%")
                                          ->orWhere('customer_name', 'like', "%{$query}%")
                                          ->orWhere('customer_phone', 'like', "%{$query}%");
                            })
                            ->orWhereHas('order.user', function($userQuery) use ($query) {
                                $userQuery->where('name', 'like', "%{$query}%");
                            });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('deliveries.index', compact('deliveries', 'query'));
    }

    public function updateStatus(Request $request, Delivery $delivery)
    {
        $request->validate([
            'status' => 'required|in:En cours de livraison,Déjà payé mais non livré,Déjà payé et livré,Livré,Annulé,En cours de traitement,Retour mais déjà payé,Retour mais pas payé',
        ]);

        $delivery->status = $request->status;

        if ($request->status === 'Livré' || $request->status === 'Déjà payé et livré') {
            $delivery->delivered_at = now();
        }

        $delivery->save();

        return back()->with('success', 'Statut de livraison mis à jour');
    }

    public function dailyDeliverySheet(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $deliveries = Delivery::with(['order.user', 'order.orderItems.product'])
            ->whereHas('order', function($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->whereNotIn('status', ['Livré', 'Déjà payé et livré', 'Annulé'])
            ->orderBy('created_at', 'asc')
            ->get();

        $pdf = PDF::loadView('deliveries.daily-sheet', compact('deliveries', 'date'));

        return $pdf->download('fiche_livraison_' . $date . '.pdf');
    }

    public function pastDeliverySheets()
    {
        // Récupérer les dates uniques des livraisons des 30 derniers jours
        $dates = Delivery::with(['order'])
            ->whereHas('order', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->get()
            ->groupBy(function($delivery) {
                return $delivery->order->created_at->format('Y-m-d');
            })
            ->map(function($group) {
                $firstDelivery = $group->first();
                return [
                    'date' => $firstDelivery->order->created_at->format('Y-m-d'),
                    'date_formatted' => $firstDelivery->order->created_at->format('d/m/Y'),
                    'total_deliveries' => $group->count(),
                    'total_amount' => $group->sum('order.total_amount'),
                    'pending_count' => $group->whereNotIn('status', ['Livré', 'Déjà payé et livré', 'Annulé'])->count()
                ];
            })
            ->sortByDesc('date')
            ->values();

        return view('deliveries.past-sheets', compact('dates'));
    }
}
