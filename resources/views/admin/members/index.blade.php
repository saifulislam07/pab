@extends('layouts.admin')

@section('title', 'Member Moderation')
@section('page_title', 'Member Moderation')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">List of {{ ucfirst($status) }} Members</h3>
                <div class="card-tools d-flex">
                    <form action="{{ route('admin.members.index') }}" method="GET" class="input-group input-group-sm mr-2" style="width: 250px;">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="text" name="search" class="form-control" placeholder="Search name or role..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.members.index', ['status' => $status]) }}" class="btn btn-danger" title="Clear Search">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                    <div class="btn-group">
                        <a href="{{ route('admin.members.index', ['status' => 'pending', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'pending' ? 'btn-primary' : 'btn-default' }}">Pending</a>
                        <a href="{{ route('admin.members.index', ['status' => 'approved', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'approved' ? 'btn-primary' : 'btn-default' }}">Approved</a>
                        <a href="{{ route('admin.members.index', ['status' => 'rejected', 'search' => request('search')]) }}" class="btn btn-sm {{ $status == 'rejected' ? 'btn-primary' : 'btn-default' }}">Rejected</a>
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
                            <td class="align-middle font-weight-bold">{{ $member->name }}</td>
                            <td class="align-middle text-muted">{{ $member->role }}</td>
                            <td class="align-middle">{{ $member->created_at->format('M d, Y') }}</td>
                            <td class="text-right align-middle">
                                @if($status != 'approved')
                                <form action="{{ route('admin.members.update-status', $member->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif

                                @if($status != 'rejected')
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
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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
