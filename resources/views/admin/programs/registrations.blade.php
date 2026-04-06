@extends('layouts.admin')

@section('title', 'Program Registrations: ' . $program->title)
@section('page_title', 'Registrations for ' . $program->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registration List</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-sm btn-default">
                        <i class="fas fa-arrow-left"></i> Back to Programs
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Registration Details</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($registration->user)
                                        {{ $registration->user->name }}<br>
                                        <small>{{ $registration->user->email }}</small>
                                    @else
                                        Guest
                                    @endif
                                </td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($registration->registration_data as $key => $value)
                                            <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $program->registration_fee > 0 ? '$' . number_format($program->registration_fee, 2) : 'Free' }}</td>
                                <td>
                                    <span class="badge badge-{{ $registration->status == 'confirmed' ? 'success' : ($registration->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td>{{ $registration->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No registrations found for this program.</td>
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
