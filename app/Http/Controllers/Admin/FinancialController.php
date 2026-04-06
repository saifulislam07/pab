<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FinancialController extends Controller {
    // --- CATEGORIES ---
    public function categories() {
        $categories = AccountCategory::orderBy('type')->orderBy('name')->get();
        return view('admin.finance.categories', compact('categories'));
    }

    public function storeCategory(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string',
        ]);

        AccountCategory::create($request->all());
        return back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, AccountCategory $category) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string',
        ]);

        $category->update($request->all());
        return back()->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(AccountCategory $category) {
        if ($category->transactions()->exists()) {
            return back()->with('error', 'Cannot delete category that has transactions.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }

    // --- TRANSACTIONS (INCOME) ---
    public function income(Request $request) {
        $categories = AccountCategory::income()->active()->get();
        $transactions = Transaction::where('type', 'income')
            ->with('category')
            ->latest()
            ->paginate(20);
            
        return view('admin.finance.income', compact('categories', 'transactions'));
    }

    // --- TRANSACTIONS (EXPENSE) ---
    public function expense(Request $request) {
        $categories = AccountCategory::expense()->active()->get();
        $transactions = Transaction::where('type', 'expense')
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('admin.finance.expense', compact('categories', 'transactions'));
    }

    // --- COMMON TRANSACTION METHODS ---
    public function storeTransaction(Request $request) {
        $request->validate([
            'account_category_id' => 'required|exists:account_categories,id',
            'amount'              => 'required|numeric|min:0',
            'date'                => 'required|date',
            'description'         => 'nullable|string',
            'type'                => 'required|in:income,expense',
        ]);

        Transaction::create($request->all());
        return back()->with('success', ucfirst($request->type) . ' recorded successfully.');
    }

    public function updateTransaction(Request $request, Transaction $transaction) {
        $request->validate([
            'account_category_id' => 'required|exists:account_categories,id',
            'amount'              => 'required|numeric|min:0',
            'date'                => 'required|date',
            'description'         => 'nullable|string',
        ]);

        $transaction->update($request->all());
        return back()->with('success', 'Transaction updated successfully.');
    }

    public function destroyTransaction(Transaction $transaction) {
        $type = $transaction->type;
        $transaction->delete();
        return back()->with('success', ucfirst($type) . ' record deleted.');
    }

    // --- REPORTS ---
    public function report(Request $request) {
        $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Income by Category
        $incomeByCat = AccountCategory::income()
            ->with(['transactions' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($category) {
                $category->total_amount = $category->transactions->sum('amount');
                return $category;
            })->filter(fn($cat) => $cat->total_amount > 0);

        // Expense by Category
        $expenseByCat = AccountCategory::expense()
            ->with(['transactions' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($category) {
                $category->total_amount = $category->transactions->sum('amount');
                return $category;
            })->filter(fn($cat) => $cat->total_amount > 0);

        $totalIncome = $incomeByCat->sum('total_amount');
        $totalExpense = $expenseByCat->sum('total_amount');
        $netBalance = $totalIncome - $totalExpense;

        return view('admin.finance.report', compact('incomeByCat', 'expenseByCat', 'totalIncome', 'totalExpense', 'netBalance', 'startDate', 'endDate'));
    }
}
