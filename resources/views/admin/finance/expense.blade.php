@extends('layouts.admin')

@section('title', 'Expense Management')
@section('page_title', 'All Expense Records')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 bg-danger-light">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold text-danger mb-1">Expense Tracker</h2>
                        <p class="mb-0 text-muted italic">Track all association costs including office rent, travel, and event logistics.</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <button type="button" class="btn btn-danger font-weight-bold shadow-sm px-4" data-toggle="modal" data-target="#addExpenseModal">
                            <i class="fas fa-minus-circle mr-1"></i> Record New Expense
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h3 class="card-title font-weight-bold text-gray-800">
                    <i class="fas fa-receipt text-danger mr-2"></i>
                    Transaction History (Expense)
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 border-0">Date</th>
                                <th class="border-0">Category</th>
                                <th class="border-0">Description</th>
                                <th class="border-0 text-center">Amount</th>
                                <th class="px-4 border-0 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-3">{{ $transaction->date->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $transaction->category->icon ?? 'fas fa-circle' }} text-danger mr-2 opacity-50"></i>
                                            <span class="font-weight-bold">{{ $transaction->category->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="text-gray-900 font-semibold">{{ $transaction->description }}</div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="font-weight-black text-danger" style="font-size: 1.1rem;">
                                            {{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button type="button" class="btn btn-sm btn-outline-info shadow-sm mr-1" data-toggle="modal" data-target="#editExpense{{ $transaction->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.finance.transaction.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" onclick="return confirm('Delete this expense record?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editExpense{{ $transaction->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-gray-50">
                                                <h5 class="modal-title font-weight-bold">Edit Expense Record</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form action="{{ route('admin.finance.transaction.update', $transaction->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Date</label>
                                                        <input type="date" name="date" class="form-control" value="{{ $transaction->date->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Expense Category</label>
                                                        <select name="account_category_id" class="form-control" required>
                                                            @foreach($categories as $cat)
                                                                <option value="{{ $cat->id }}" {{ $transaction->account_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Amount (BDT)</label>
                                                        <input type="number" step="0.01" name="amount" class="form-control font-weight-bold text-danger" value="{{ $transaction->amount }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Description / Purpose</label>
                                                        <textarea name="description" class="form-control" rows="3">{{ $transaction->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary font-weight-bold">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-hand-holding-usd fa-3x opacity-25 mb-3 d-block"></i>
                                        No expense records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($transactions->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-top border-danger border-lg">
            <div class="modal-header bg-white text-danger">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-minus-circle mr-2"></i> Record New Expense</h5>
                <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.finance.transaction.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="expense">
                <div class="modal-body border-0">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Amount (BDT)</label>
                            <input type="number" step="0.01" name="amount" class="form-control font-weight-bold text-danger border-danger-light" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Expense Category</label>
                        <select name="account_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Description / Purpose</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Explain what this expense is for..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4 shadow-sm">Save Expense Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.05); }
    .border-danger-light { border-color: rgba(220, 53, 69, 0.3) !important; }
    .font-weight-black { font-weight: 900 !important; }
    .italic { font-style: italic; }
    .border-lg { border-top-width: 5px !important; }
</style>
@endsection
