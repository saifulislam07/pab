@extends('layouts.admin')

@section('title', 'Membership Applications')
@section('page_title', 'Membership Applications')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ ucfirst($status) }} Applications</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{ route('admin.membership.index', ['status' => 'pending']) }}" class="btn btn-sm {{ $status == 'pending' ? 'btn-primary' : 'btn-default' }}">Pending</a>
                        <a href="{{ route('admin.membership.index', ['status' => 'active']) }}" class="btn btn-sm {{ $status == 'active' ? 'btn-primary' : 'btn-default' }}">Active</a>
                        <a href="{{ route('admin.membership.index', ['status' => 'expired']) }}" class="btn btn-sm {{ $status == 'expired' ? 'btn-primary' : 'btn-default' }}">Expired</a>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Plan</th>
                            <th>Payment Info</th>
                            <th>Proof</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $member->image ? asset('storage/' . $member->image) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" width="40" height="40" class="img-circle mr-2">
                                    <div>
                                        <div class="font-weight-bold">{{ $member->name }}</div>
                                        <small class="text-muted">{{ $member->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ $member->membership_type == 'lifetime' ? 'badge-primary' : 'badge-info' }}">
                                    {{ ucfirst($member->membership_type) }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <strong>{{ $member->payment_method }}</strong> <br>
                                <small>ID: {{ $member->transaction_id }}</small> <br>
                                <span class="badge badge-success">{{ number_format($member->membership_amount, 2) }} TK</span>
                            </td>
                            <td class="align-middle">
                                @if($member->payment_proof)
                                    <a href="{{ asset('storage/' . $member->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $member->payment_proof) }}" width="50" height="50" style="object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                    </a>
                                @else
                                    <span class="text-muted">No Proof</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($member->membership_started_at)
                                    <small>Expires: {{ $member->membership_expires_at->format('M d, Y') }}</small>
                                @else
                                    <small>Applied: {{ $member->updated_at->format('M d, Y') }}</small>
                                @endif
                            </td>
                            <td class="text-right align-middle">
                                <div class="btn-group">
                                    @if($member->membership_status == 'pending')
                                        <form action="{{ route('admin.membership.approve', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this membership?')">
                                                <i class="fas fa-check mr-1"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.membership.reject', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Reject this application?')">
                                                <i class="fas fa-times mr-1"></i> Reject
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye mr-1"></i> View Profile
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No {{ $status }} applications found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
