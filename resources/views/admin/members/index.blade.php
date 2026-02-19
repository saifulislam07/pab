@extends('layouts.admin')

@section('title', 'Member Moderation')
@section('page_title', 'Member Moderation')

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
        margin-left: 6px;
        width: 18px;
        height: 18px;
        vertical-align: middle;
    }
    .badge-icon-wrap .fa-certificate {
        font-size: 1.1rem;
    }
    .badge-icon-wrap .fa-check {
        position: absolute;
        font-size: 0.5rem;
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
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">List of {{ ucfirst($status) }} Members</h3>
                <div class="card-tools d-flex align-items-center">
                    @include('admin.partials.search', [
                        'route' => route('admin.members.index'),
                        'placeholder' => 'Search name or role...',
                        'params' => ['status' => $status],
                        'clearRoute' => route('admin.members.index', ['status' => $status])
                    ])
                    <div class="btn-group mr-2">
                        <a href="{{ route('admin.members.export', ['status' => $status, 'search' => request('search')]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-file-csv mr-1"></i> Export {{ ucfirst($status) }} CSV
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin.members.index', ['status' => 'pending', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'pending' ? 'btn-primary' : 'btn-default' }}">Pending</a>
                        <a href="{{ route('admin.members.index', ['status' => 'approved', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'approved' ? 'btn-primary' : 'btn-default' }}">Approved</a>
                        <a href="{{ route('admin.members.index', ['status' => 'rejected', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'rejected' ? 'btn-primary' : 'btn-default' }}">Rejected</a>
                        <a href="{{ route('admin.members.index', ['status' => 'blocked', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'blocked' ? 'btn-primary' : 'btn-default' }}">Blocked</a>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>
                                <img src="{{ $member->image ? asset('storage/' . $member->image) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" width="45" height="45" class="img-circle elevation-2">
                            </td>
                            <td class="align-middle font-weight-bold">
                                {{ $member->name }}
                                @if($member->isActiveMember())
                                    <span class="badge-icon-wrap">
                                        <i class="fas fa-certificate animate-pulse-slow {{ $member->membership_type === 'lifetime' ? 'badge-lifetime' : 'badge-yearly' }}"></i>
                                        <i class="fas fa-check"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle text-muted">{{ $member->role }}</td>
                            <td class="align-middle">{{ $member->created_at->format('M d, Y') }}</td>
                            <td class="text-right align-middle">
                                <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-info" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($status == 'pending' || $status == 'rejected')
                                <form action="{{ route('admin.members.update-status', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif

                                @if($status == 'approved')
                                <form action="{{ route('admin.members.update-status', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="blocked">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Block" onclick="return confirm('Are you sure you want to block this member?')">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                @endif

                                @if($status == 'blocked')
                                <form action="{{ route('admin.members.update-status', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success" title="Unblock">
                                        <i class="fas fa-unlock"></i>
                                    </button>
                                </form>
                                @endif

                                @if($status == 'pending' || $status == 'approved')
                                <form action="{{ route('admin.members.update-status', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-warning text-white" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No {{ $status }} members found.</td>
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
