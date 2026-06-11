<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $category = $request->input('category');

        $expenses = Expense::with('user')
            ->when($query, function($q) use ($query) {
                $q->where(function($subQuery) use ($query) {
                    $subQuery->where('description', 'like', "%{$query}%")
                            ->orWhere('notes', 'like', "%{$query}%")
                            ->orWhere('receipt_number', 'like', "%{$query}%");
                });
            })
            ->when($category, function($q) use ($category) {
                $q->where('category', $category);
            })
            ->orderBy('expense_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = Expense::distinct()->pluck('category')->filter();
        $totalExpenses = Expense::sum('amount');

        return view('expenses.index', compact('expenses', 'query', 'category', 'categories', 'totalExpenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'Transport' => 'Transport',
            'Fournitures' => 'Fournitures',
            'Loyer' => 'Loyer',
            'Salaires' => 'Salaires',
            'Marketing' => 'Marketing',
            'Maintenance' => 'Maintenance',
            'Autres' => 'Autres'
        ];

        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:100'
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
            'notes' => $request->notes,
            'receipt_number' => $request->receipt_number,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Dépense ajoutée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $categories = [
            'Transport' => 'Transport',
            'Fournitures' => 'Fournitures',
            'Loyer' => 'Loyer',
            'Salaires' => 'Salaires',
            'Marketing' => 'Marketing',
            'Maintenance' => 'Maintenance',
            'Autres' => 'Autres'
        ];

        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:100'
        ]);

        $expense->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
            'notes' => $request->notes,
            'receipt_number' => $request->receipt_number
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Dépense mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Dépense supprimée avec succès!');
    }

    /**
     * Export expenses to PDF
     */
    public function exportPDF(Request $request)
    {
        $query = $request->input('search');
        $category = $request->input('category');

        $expenses = Expense::with('user')
            ->when($query, function($q) use ($query) {
                $q->where(function($subQuery) use ($query) {
                    $subQuery->where('description', 'like', "%{$query}%")
                            ->orWhere('notes', 'like', "%{$query}%")
                            ->orWhere('receipt_number', 'like', "%{$query}%");
                });
            })
            ->when($category, function($q) use ($category) {
                $q->where('category', $category);
            })
            ->orderBy('expense_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalExpenses = $expenses->sum('amount');

        $pdf = PDF::loadView('expenses.pdf', compact('expenses', 'totalExpenses', 'query', 'category'));

        return $pdf->download('depenses_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export expenses to CSV
     */
    public function exportCSV(Request $request)
    {
        $query = $request->input('search');
        $category = $request->input('category');

        $expenses = Expense::with('user')
            ->when($query, function($q) use ($query) {
                $q->where(function($subQuery) use ($query) {
                    $subQuery->where('description', 'like', "%{$query}%")
                            ->orWhere('notes', 'like', "%{$query}%")
                            ->orWhere('receipt_number', 'like', "%{$query}%");
                });
            })
            ->when($category, function($q) use ($category) {
                $q->where('category', $category);
            })
            ->orderBy('expense_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "depenses_" . now()->format('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($expenses) {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'Date', 'Description', 'Catégorie', 'Montant (FCFA)',
                'Numéro Reçu', 'Notes', 'Utilisateur', 'Créé le'
            ]);

            // CSV Data
            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->expense_date->format('d/m/Y'),
                    $expense->description,
                    $expense->category,
                    number_format($expense->amount, 2, ',', ' '),
                    $expense->receipt_number ?? '',
                    $expense->notes ?? '',
                    $expense->user->name,
                    $expense->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
