@extends('layouts.admin')

@section('title', 'Membership Status')
@section('page_title', 'Membership Status')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-outline {{ $member->isActiveMember() ? 'card-success' : 'card-warning' }}">
            <div class="card-header">
                <h3 class="card-title">Your Current Plan</h3>
            </div>
            <div class="card-body text-center p-5">
                @if($member->membership_status === 'none')
                    <div class="py-4">
                        <i class="fas fa-id-card-alt fa-4x text-muted mb-3"></i>
                        <h4>No Active Membership</h4>
                        <p class="text-muted">You haven't applied for a membership plan yet. Apply now to get listed and unlock all features.</p>
                        <a href="{{ route('member.membership.apply') }}" class="btn btn-primary btn-lg mt-3">
                            Apply for Membership
                        </a>
                    </div>
                @elseif($member->membership_status === 'pending')
                    <div class="py-4">
                        <i class="fas fa-clock fa-4x text-warning mb-3"></i>
                        <h4>Application Pending</h4>
                        <p class="text-muted">Your application for <strong>{{ ucfirst($member->membership_type) }} Membership</strong> is currently under review by our administrators.</p>
                        <div class="alert alert-secondary d-inline-block mt-3">
                            <strong>Transaction ID:</strong> {{ $member->transaction_id }}
                        </div>
                    </div>
                @elseif($member->isActiveMember())
                    <div class="py-4">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h2 class="text-success">{{ ucfirst($member->membership_type) }} Member</h2>
                        <h5 class="mt-3">Status: <span class="badge badge-success">ACTIVE</span></h5>
                        <p class="mt-4">
                            <strong>Valid From:</strong> {{ $member->membership_started_at->format('M d, Y') }} <br>
                            <strong>Expires On:</strong> {{ $member->membership_expires_at->format('M d, Y') }}
                        </p>
                        <div class="mt-4">
                            <h3 class="font-weight-bold text-primary">{{ $member->getMembershipRemainingDays() }}Days</h3>
                            <span class="text-muted">Remaining Valid Time</span>
                        </div>
                    </div>
                @elseif($member->membership_status === 'expired')
                    <div class="py-4">
                        <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                        <h4 class="text-danger">Membership Expired</h4>
                        <p class="text-muted">Your membership expired on {{ $member->membership_expires_at->format('M d, Y') }}. Please renew to stay active.</p>
                        <a href="{{ route('member.membership.apply') }}" class="btn btn-danger btn-lg mt-3">
                            Renew Membership
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
