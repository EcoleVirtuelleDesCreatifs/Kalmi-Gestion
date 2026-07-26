<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Selling;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $sellings = Selling::with(['user', 'product'])
            ->when($query, function($q) use ($query) {
                $q->where('notes', 'like', "%{$query}%");
            })
            ->orderBy('selling_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalSellings = Selling::sum('amount');
        $todaySellings = Selling::whereDate('selling_date', today())->sum('amount');

        return view('sellings.index', compact('sellings', 'query', 'totalSellings', 'todaySellings'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('sellings.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'selling_date' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
            'notes' => 'nullable|string'
        ]);

        Selling::create([
            'amount' => $request->amount,
            'selling_date' => $request->selling_date,
            'product_id' => $request->product_id,
            'notes' => $request->notes,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('sellings.index')
            ->with('success', 'Vente enregistrée avec succès!');
    }

    public function show(Selling $selling)
    {
        return view('sellings.show', compact('selling'));
    }

    public function edit(Selling $selling)
    {
        $products = Product::orderBy('name')->get();
        return view('sellings.edit', compact('selling', 'products'));
    }

    public function update(Request $request, Selling $selling)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'selling_date' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
            'notes' => 'nullable|string'
        ]);

        $selling->update([
            'amount' => $request->amount,
            'selling_date' => $request->selling_date,
            'product_id' => $request->product_id,
            'notes' => $request->notes
        ]);

        return redirect()->route('sellings.index')
            ->with('success', 'Vente mise à jour avec succès!');
    }

    public function destroy(Selling $selling)
    {
        $selling->delete();

        return redirect()->route('sellings.index')
            ->with('success', 'Vente supprimée avec succès!');
    }
}
