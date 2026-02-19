@extends('layouts.admin')

@section('title', 'Member Details - ' . $member->name)
@section('page_title', 'Member Details')

@section('styles')
<style>
    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    .badge-icon-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 8px;
        vertical-align: middle;
    }
    .badge-icon-wrap .fa-certificate {
        font-size: 1.5rem;
    }
    .badge-icon-wrap .fa-check {
        position: absolute;
        font-size: 0.7rem;
        color: #fff;
    }
    .badge-lifetime {
        color: #1e3a8a;
        filter: drop-shadow(0 0 4px rgba(30, 58, 138, 0.6));
    }
    .badge-yearly {
        color: #60a5fa;
        filter: drop-shadow(0 0 4px rgba(96, 165, 250, 0.6));
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($member->image)
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ asset('storage/' . $member->image) }}"
                             alt="User profile picture">
                    @else
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ asset('images/default-avatar.png') }}"
                             alt="User profile picture">
                    @endif
                </div>

                <h3 class="profile-username text-center">
                    {{ $member->name }}
                    @if($member->isActiveMember())
                        <span class="badge-icon-wrap">
                            <i class="fas fa-certificate animate-pulse-slow {{ $member->membership_type === 'lifetime' ? 'badge-lifetime' : 'badge-yearly' }}"></i>
                            <i class="fas fa-check"></i>
                        </span>
                    @endif
                </h3>
                <p class="text-muted text-center">{{ $member->role }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Member ID</b> <a class="float-right text-primary font-weight-bold">{{ $member->member_id ?? 'N/A' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> 
                        <span class="float-right badge @if($member->status == 'approved') badge-success @elseif($member->status == 'blocked') badge-danger @elseif($member->status == 'rejected') badge-secondary @else badge-warning @endif">
                            {{ ucfirst($member->status) }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Completion</b> <a class="float-right text-info font-weight-bold">{{ $member->getCompletionPercentage() }}%</a>
                    </li>
                </ul>

                <form action="{{ route('admin.members.update-status', $member) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Update Status</label>
                        <select name="status" class="form-control form-control-sm mb-2" onchange="this.form.submit()">
                            <option value="pending" {{ $member->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $member->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $member->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="blocked" {{ $member->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Reset Box -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">Reset Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.members.update-password', $member) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger btn-block">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Address</a></li>
                    <li class="nav-item"><a class="nav-link" href="#photography" data-toggle="tab">Photography</a></li>
                    <li class="nav-item"><a class="nav-link" href="#social" data-toggle="tab">Social</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="details">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Full Name</th>
                                <td>{{ $member->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $member->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $member->mobile ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $member->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Profession</th>
                                <td>{{ $member->profession ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Bio</th>
                                <td>{{ $member->bio ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="tab-pane" id="address">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Division</th>
                                <td>{{ $member->division ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td>{{ $member->district ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Upazila</th>
                                <td>{{ $member->upazila ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Current Location</th>
                                <td>{{ $member->current_location ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="tab-pane" id="photography">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Specialization</th>
                                <td>{{ $member->specialization ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Experience Level</th>
                                <td>{{ $member->experience_level ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Camera Gear</th>
                                <td>{{ $member->camera_gear ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="tab-pane" id="social">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Facebook</th>
                                <td>@if($member->facebook) <a href="{{ $member->facebook }}" target="_blank">{{ $member->facebook }}</a> @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>Instagram</th>
                                <td>@if($member->instagram) <a href="{{ $member->instagram }}" target="_blank">{{ $member->instagram }}</a> @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>LinkedIn</th>
                                <td>@if($member->linkedin) <a href="{{ $member->linkedin }}" target="_blank">{{ $member->linkedin }}</a> @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>@if($member->website) <a href="{{ $member->website }}" target="_blank">{{ $member->website }}</a> @else N/A @endif</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.members.index', ['status' => $member->status]) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
