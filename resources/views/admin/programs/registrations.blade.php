@extends('layouts.admin')

@section('title', 'Program Registrations: ' . $program->title)
@section('page_title', 'Registrations for ' . $program->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registration List</h3>
                <div class="card-tools d-flex align-items-center">
                    @include('admin.partials.search', [
                        'route' => route('admin.programs.registrations', $program->id),
                        'placeholder' => 'Search name, email, data...',
                        'clearRoute' => route('admin.programs.registrations', $program->id)
                    ])

                    <a href="{{ route('admin.programs.registrations.export', $program->id) }}" class="btn btn-sm btn-success mr-2">
                        <i class="fas fa-file-excel"></i> Export CSV
                    </a>

                    <a href="{{ route('admin.programs.index') }}" class="btn btn-sm btn-default">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Amount</th>
                            <th>Trans ID</th>
                            <th>Note</th>
                            <th>Form No</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td class="font-weight-bold text-primary">{{ $registration->formatted_id }}</td>
                                <td>{{ $registration->getField('name') ?: ($registration->user->name ?? 'N/A') }}</td>
                                <td>{{ $registration->getField('mobile') ?: ($registration->user->phone ?? 'N/A') }}</td>
                                <td>
                                    <span class="badge badge-light p-2 border">
                                        {{ $registration->getField('amount') ?: ($registration->program->registration_fee > 0 ? $registration->program->registration_fee : 'Free') }}
                                    </span>
                                </td>
                                <td class="text-xs font-weight-bold">{{ $registration->transaction_id ?: $registration->getField('trans_id') ?: 'N/A' }}</td>
                                <td class="text-xs text-muted">{{ Str::limit($registration->getField('note'), 30) }}</td>
                                <td>{{ $registration->getField('form_no') ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $registration->status == 'accept' ? 'success' : ($registration->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="d-flex justify-content-end" style="gap: 5px;">
                                        <a href="{{ route('admin.programs.registrations.show', $registration->id) }}" class="btn btn-sm btn-info text-white" title="View Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        
                                        @if($registration->status != 'accept')
                                            <form action="{{ route('admin.programs.registrations.status', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accept">
                                                <button type="submit" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Approve registration {{ $registration->formatted_id }}?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($registration->status != 'reject')
                                            <form action="{{ route('admin.programs.registrations.status', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="reject">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Reject" onclick="return confirm('Reject registration {{ $registration->formatted_id }}?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                    No registrations found for this program matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $registrations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
