@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 bg-info">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold mb-1">Welcome Back, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                        <p class="mb-0 opacity-75">Here is what's happening with PAB today. Check the latest member requests and program registrations below.</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <div class="btn-group shadow-sm">
                            <a href="{{ route('admin.programs.create') }}" class="btn btn-light font-weight-bold">
                                <i class="fas fa-plus-circle mr-1"></i> New Program
                            </a>
                            <a href="{{ route('admin.gallery.batch') }}" class="btn btn-light font-weight-bold border-left">
                                <i class="fas fa-images mr-1"></i> Add Photos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Key KPIs -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border rounded-lg h-100 overflow-hidden">
            <div class="inner p-4">
                <h3 class="font-weight-black text-primary">{{ number_format($stats['total_members'] ?? 0) }}</h3>
                <p class="text-muted font-weight-bold uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 1px;">Approved Members</p>
            </div>
            <div class="icon text-primary-light" style="opacity: 0.1; top: 10px; right: 20px;">
                <i class="fas fa-id-card fa-4x"></i>
            </div>
            <a href="{{ route('admin.members.index', ['status' => 'approved']) }}" class="small-box-footer bg-light text-primary border-top">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border rounded-lg h-100 overflow-hidden">
            <div class="inner p-4">
                <h3 class="font-weight-black text-warning">{{ number_format($stats['pending_members'] ?? 0) }}</h3>
                <p class="text-muted font-weight-bold uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 1px;">Pending Approvals</p>
            </div>
            <div class="icon text-warning-light" style="opacity: 0.1; top: 10px; right: 20px;">
                <i class="fas fa-user-clock fa-4x"></i>
            </div>
            <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="small-box-footer bg-light text-warning border-top">
                Review Now <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border rounded-lg h-100 overflow-hidden">
            <div class="inner p-4">
                <h3 class="font-weight-black text-success">{{ number_format($stats['active_programs'] ?? 0) }}</h3>
                <p class="text-muted font-weight-bold uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 1px;">Active Programs</p>
            </div>
            <div class="icon text-success-light" style="opacity: 0.1; top: 10px; right: 20px;">
                <i class="fas fa-calendar-check fa-4x"></i>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="small-box-footer bg-light text-success border-top">
                Manage Events <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border rounded-lg h-100 overflow-hidden">
            <div class="inner p-4 text-center">
                <h3 class="font-weight-black text-danger">{{ number_format($stats['total_income'] ?? 0, 2) }}</h3>
                <p class="text-muted font-weight-bold uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 1px;">Total Income</p>
            </div>
            <a href="{{ route('admin.finance.income') }}" class="small-box-footer bg-light text-danger border-top">
                Income Details <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border rounded-lg h-100 overflow-hidden">
            <div class="inner p-4 text-center">
                <h3 class="font-weight-black text-secondary">{{ number_format($stats['total_expense'] ?? 0, 2) }}</h3>
                <p class="text-muted font-weight-bold uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 1px;">Total Expense</p>
            </div>
            <a href="{{ route('admin.finance.expense') }}" class="small-box-footer bg-light text-secondary border-top">
                Expense Details <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border rounded-lg h-100 overflow-hidden">
            <div class="inner p-4 text-center">
                <h3 class="font-weight-black {{ ($stats['net_balance'] ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($stats['net_balance'] ?? 0, 2) }}
                </h3>
                <p class="text-muted font-weight-bold uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 1px;">Net Balance</p>
            </div>
            <div class="small-box-footer bg-light text-muted border-top text-center py-2">
                Cash in Hand / Profit
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Chart Column -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h3 class="card-title font-weight-bold text-gray-800">
                    <i class="fas fa-chart-line text-primary mr-2"></i>
                    Registration Activity (Last 30 Days)
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="registrationChart" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Members Column -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h3 class="card-title font-weight-bold text-gray-800">
                    <i class="fas fa-user-plus text-warning mr-2"></i>
                    Latest Join Requests
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @forelse($recent_member_requests as $member)
                        <li class="item py-3">
                            <div class="product-img">
                                <img src="{{ $member->photo ? asset($member->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=f3f4f6&color=111827' }}" alt="User Image" class="img-size-50 rounded-circle shadow-sm">
                            </div>
                            <div class="product-info ml-3">
                                <a href="{{ route('admin.members.show', $member->id) }}" class="product-title font-weight-bold text-gray-900">
                                    {{ $member->name }}
                                </a>
                                <span class="product-description text-muted small">
                                    Requested {{ $member->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="item py-5 text-center text-muted">
                            <i class="fas fa-check-circle text-gray-300 fa-3x mb-3"></i>
                            <p class="mb-0">No pending member requests.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
            @if($recent_member_requests->count() > 0)
                <div class="card-footer text-center bg-white border-top">
                    <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="uppercase font-weight-bold small text-primary">View All Requests</a>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Program Registrations Table -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h3 class="card-title font-weight-bold text-gray-800">
                    <i class="fas fa-file-invoice text-success mr-2"></i>
                    Recent Program Registrations
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 font-weight-bold px-4">Date</th>
                                <th class="border-0 font-weight-bold">ID / Form No</th>
                                <th class="border-0 font-weight-bold">Program</th>
                                <th class="border-0 font-weight-bold">Status</th>
                                <th class="border-0 font-weight-bold text-right px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_registrations as $reg)
                                <tr>
                                    <td class="px-4 py-3">{{ $reg->created_at->format('M d, Y') }}</td>
                                    <td class="py-3">
                                        <div class="font-weight-bold text-primary">{{ $reg->formatted_id }}</div>
                                        <small class="text-muted">Form: {{ $reg->getField('form_no') ?? 'N/A' }}</small>
                                    </td>
                                    <td class="py-3">
                                        <span class="font-weight-bold">{{ $reg->program->title ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $badgeClass = $reg->status == 'accept' ? 'success' : ($reg->status == 'reject' ? 'danger' : 'warning');
                                        @endphp
                                        <span class="badge border border-{{ $badgeClass }} text-{{ $badgeClass }} px-3 py-1 font-weight-bold text-uppercase" style="font-size: 0.65rem;">{{ $reg->status }}</span>
                                    </td>
                                    <td class="px-4 text-right py-3">
                                        <a href="{{ route('admin.programs.registrations.show', $reg->id) }}" class="btn btn-sm btn-outline-primary shadow-sm">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        No program registrations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($recent_registrations->count() > 0)
                <div class="card-footer bg-white border-top text-right">
                    <span class="text-muted small mr-3 italic">Showing the last 8 registrations</span>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-xs btn-primary font-weight-bold shadow-sm">View by Program</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        var ctx = document.getElementById('registrationChart').getContext('2d');
        
        // Prepare chart data from PHP
        var labels = @json(array_column($chart_data, 'date'));
        var counts = @json(array_column($chart_data, 'count'));

        var registrationChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Registrations',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointHoverBorderColor: '#fff',
                    spanGaps: false,
                    data: counts,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            color: '#8e8e8e',
                            font: { size: 11 }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                        },
                        ticks: {
                            stepSize: 5,
                            color: '#8e8e8e',
                            font: { size: 11 }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<style>
    .font-weight-black { font-weight: 900 !important; }
    .uppercase { text-transform: uppercase; }
    .img-size-50 { width: 50px; height: 50px; object-fit: cover; }
    .small-box { transition: transform .3s ease-in-out, box-shadow .3s ease-in-out; }
    .small-box:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important; }
    .badge { border-width: 2px !important; border-radius: 50px; }
</style>
@endsection
