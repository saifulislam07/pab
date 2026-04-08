@extends('layouts.admin')

@section('title', 'Income Management')
@section('page_title', 'All Income Records')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm border-0 bg-success-light">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold text-success mb-1">Income Tracker</h2>
                        <p class="mb-0 text-muted italic">Manage association earnings from programs, sponsorships, and donations.</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <button type="button" class="btn btn-success font-weight-bold shadow-sm" data-toggle="modal" data-target="#addIncomeModal">
                            <i class="fas fa-plus-circle mr-1"></i> Record New Income
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
                    <i class="fas fa-file-invoice-dollar text-success mr-2"></i>
                    Transaction History (Income)
                </h3>
                <div class="card-tools">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 40px" class="pl-4">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="selectAll">
                                        <label for="selectAll" class="custom-control-label"></label>
                                    </div>
                                </th>
                                <th class="border-0">Date</th>
                                <th class="border-0">Category</th>
                                <th class="border-0">Description / Reference</th>
                                <th class="border-0 text-center">Amount</th>
                                <th class="px-4 border-0 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="pl-4 py-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input bulk-checkbox" type="checkbox" id="checkbox-{{ $transaction->id }}" value="{{ $transaction->id }}">
                                            <label for="checkbox-{{ $transaction->id }}" class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td class="py-3">{{ $transaction->date->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $transaction->category->icon ?? 'fas fa-circle' }} text-success mr-2 opacity-50"></i>
                                            <span class="font-weight-bold">{{ $transaction->category->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="text-gray-900 font-semibold">{{ $transaction->description }}</div>
                                        @if($transaction->reference_type == 'program_registration')
                                            <small class="badge bg-light border text-muted px-2 py-0" style="font-size: 0.6rem;">Program Registration</small>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="font-weight-black text-success" style="font-size: 1.1rem;">
                                            {{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button type="button" class="btn btn-sm btn-outline-info shadow-sm mr-1" data-toggle="modal" data-target="#editIncome{{ $transaction->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.finance.transaction.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" onclick="return confirm('Delete this income record?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal (omitted for brevity in replace tool if possible, but I must keep it fully functional) -->
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editIncome{{ $transaction->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold">Edit Income Record</h5>
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
                                                        <label class="font-weight-bold">Income Category</label>
                                                        <select name="account_category_id" class="form-control" required>
                                                            @foreach($categories as $cat)
                                                                <option value="{{ $cat->id }}" {{ $transaction->account_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Amount (BDT)</label>
                                                        <input type="number" step="0.01" name="amount" class="form-control font-weight-bold text-success" value="{{ $transaction->amount }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Description</label>
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
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-coins fa-3x opacity-25 mb-3 d-block"></i>
                                        No income records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Bulk Delete Form -->
                    <form id="bulkDeleteForm" action="{{ route('admin.finance.transaction.bulk-destroy') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="ids" id="selectedIds">
                    </form>
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
<div class="modal fade" id="addIncomeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold">Record New Income</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.finance.transaction.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="income">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold required-label">Date</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold required-label">Amount (BDT)</label>
                            <input type="number" step="0.01" name="amount" class="form-control font-weight-bold text-success @error('amount') is-invalid @enderror" placeholder="0.00" value="{{ old('amount') }}" required>
                            @error('amount')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold required-label">Income Category</label>
                        <select name="account_category_id" class="form-control @error('account_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('account_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('account_category_id')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Description / Source</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Explain the source of income...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold px-4">Save Income Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/admin-bulk-delete.js') }}"></script>
@endsection

@section('styles')
<style>
    .bg-success-light { background-color: rgba(40, 167, 69, 0.05); }
    .font-weight-black { font-weight: 900 !important; }
    .italic { font-style: italic; }
</style>
@endsection
