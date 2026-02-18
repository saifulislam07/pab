@extends('layouts.admin')

@section('title', 'Team Management')
@section('page_title', 'Team Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Leadership Team</h3>
                <div class="card-tools d-flex">
                    <form action="{{ route('admin.team.index') }}" method="GET" class="input-group input-group-sm d-inline-flex mr-2" style="width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Search name or role..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.team.index') }}" class="btn btn-danger" title="Clear Search">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                    <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Team Member
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td class="align-middle">{{ $member->order }}</td>
                            <td>
                                <img src="{{ $member->image ? asset('storage/' . $member->image) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" width="45" height="45" class="img-circle elevation-2">
                            </td>
                            <td class="align-middle font-weight-bold">{{ $member->name }}</td>
                            <td class="align-middle">{{ $member->role }}</td>
                            <td class="align-middle">
                                <span class="badge {{ $member->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right align-middle">
                                <a href="{{ route('admin.team.edit', $member->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
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
