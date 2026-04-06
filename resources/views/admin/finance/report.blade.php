@extends('layouts.admin')

@section('title', 'Financial Report')
@section('page_title', 'Financial Statement')

@section('content')
<div class="row mb-4 no-print">
    <div class="col-12">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body p-4">
                <form action="{{ route('admin.finance.report') }}" method="GET" class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm">
                            <i class="fas fa-filter mr-1"></i> Generate Report
                        </button>
                    </div>
                    <div class="col-md-3 mt-3 mt-md-0 text-md-right">
                        <button type="button" class="btn btn-outline-dark font-weight-bold shadow-sm px-4" onclick="window.print()">
                            <i class="fas fa-print mr-1"></i> Print Statement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="report-container shadow-sm p-5 mb-5 bg-white rounded border">
    <div class="text-center mb-5">
        <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo" class="mb-3" style="max-height: 80px;">
        <h2 class="font-weight-black text-gray-900 mb-1">PHOTOGRAPHY ASSOCIATION OF BANGLADESH</h2>
        <h4 class="text-uppercase tracking-widest text-primary font-weight-bold">Financial Statement</h4>
        <p class="text-muted mb-0">Period: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
    </div>

    <div class="row mt-5">
        <!-- Income Section -->
        <div class="col-md-6 mb-4">
            <h5 class="section-title text-success font-weight-black mb-4">
                <i class="fas fa-arrow-circle-down mr-2 opacity-50"></i> INCOME SUMMARY
            </h5>
            <table class="table table-borderless table-sm">
                <thead class="border-bottom">
                    <tr>
                        <th class="py-2 text-muted uppercase small tracking-wider">Source Category</th>
                        <th class="py-2 text-right text-muted uppercase small tracking-wider">Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incomeByCat as $income)
                        <tr class="border-bottom-dashed">
                            <td class="py-3 font-weight-bold text-gray-700">{{ $income->name }}</td>
                            <td class="py-3 text-right font-weight-black text-success">{{ number_format($income->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 text-center text-muted italic">No income recorded in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-light-success">
                    <tr class="border-top-thick">
                        <td class="py-3 font-weight-black uppercase text-success">Total Income</td>
                        <td class="py-3 text-right font-weight-black text-success" style="font-size: 1.2rem;">{{ number_format($totalIncome, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Expense Section -->
        <div class="col-md-6 mb-4 mt-5 mt-md-0">
            <h5 class="section-title text-danger font-weight-black mb-4">
                <i class="fas fa-arrow-circle-up mr-2 opacity-50"></i> EXPENSE SUMMARY
            </h5>
            <table class="table table-borderless table-sm">
                <thead class="border-bottom">
                    <tr>
                        <th class="py-2 text-muted uppercase small tracking-wider">Expense Category</th>
                        <th class="py-2 text-right text-muted uppercase small tracking-wider">Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenseByCat as $expense)
                        <tr class="border-bottom-dashed">
                            <td class="py-3 font-weight-bold text-gray-700">{{ $expense->name }}</td>
                            <td class="py-3 text-right font-weight-black text-danger">{{ number_format($expense->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 text-center text-muted italic">No expenses recorded in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-light-danger">
                    <tr class="border-top-thick">
                        <td class="py-3 font-weight-black uppercase text-danger">Total Expense</td>
                        <td class="py-3 text-right font-weight-black text-danger" style="font-size: 1.2rem;">{{ number_format($totalExpense, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Final Summary -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="p-5 {{ $netBalance >= 0 ? 'bg-success' : 'bg-danger' }} rounded-lg text-white shadow">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-1 font-weight-black uppercase tracking-widest text-shadow">Final Financial Position</h3>
                        <p class="mb-0 opacity-75 italic">Net Result for the selected period after all income and expenditure deductions.</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <span class="d-block small uppercase font-weight-bold opacity-75 mb-1">Net {{ $netBalance >= 0 ? 'Surplus' : 'Deficit' }} (BDT)</span>
                        <h1 class="font-weight-black mb-0" style="font-size: 3rem;">{{ number_format($netBalance, 2) }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 pt-5 printable-only footer-signature">
        <div class="col-4 border-top text-center pt-2">
            <p class="font-weight-bold text-gray-700 mb-0">Prepared By</p>
            <small class="text-muted">Treasurer, PAB</small>
        </div>
        <div class="col-4"></div>
        <div class="col-4 border-top text-center pt-2">
            <p class="font-weight-bold text-gray-700 mb-0">Approved By</p>
            <small class="text-muted">President, PAB</small>
        </div>
    </div>

    <div class="mt-5 text-center small text-muted italic text-shadow-sm printable-only">
        Generated on {{ date('M d, Y h:i A') }} from PAB Admin Command Center.
    </div>
</div>
@endsection

@section('styles')
<style>
    .font-weight-black { font-weight: 900 !important; }
    .uppercase { text-transform: uppercase; }
    .tracking-widest { letter-spacing: 0.1em; }
    .bg-light-success { background-color: rgba(40, 167, 69, 0.03); }
    .bg-light-danger { background-color: rgba(220, 53, 69, 0.03); }
    .border-bottom-dashed { border-bottom: 1px dashed #dee2e6; }
    .border-top-thick { border-top: 3px solid #6c757d !important; }
    .section-title { border-left: 5px solid; padding-left: 15px; }

    @media print {
        .no-print { display: none !important; }
        .main-sidebar, .main-header, .main-footer { display: none !important; }
        .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
        body { background: white !important; }
        .report-container { border: none !important; box-shadow: none !important; padding: 0 !important; }
        .printable-only { display: flex !important; }
        .footer-signature { margin-top: 50px !important; }
    }
    
    .printable-only { display: none; }
</style>
@endsection
