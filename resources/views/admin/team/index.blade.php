@extends('layouts.admin')

@section('title', 'Team Management')
@section('page_title', 'Team Management')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Leadership Team</h3>
                <div class="card-tools d-flex align-items-center">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mr-2 d-none">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>

                    @include('admin.partials.search', [
                        'route' => route('admin.team.index'),
                        'placeholder' => 'Search name or role...',
                        'clearRoute' => route('admin.team.index')
                    ])
                    <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-plus"></i> Add Team Member
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 40px">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="selectAll">
                                    <label for="selectAll" class="custom-control-label"></label>
                                </div>
                            </th>
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
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input bulk-checkbox" type="checkbox" id="checkbox-{{ $member->id }}" value="{{ $member->id }}">
                                    <label for="checkbox-{{ $member->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td class="align-middle">{{ $member->order }}</td>
                            <td>
                                <img src="{{ $member->image ? asset($member->image) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) }}" width="45" height="45" class="img-circle elevation-2">
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

                <!-- Bulk Delete Form -->
                <form id="bulkDeleteForm" action="{{ route('admin.team.bulk-destroy') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="ids" id="selectedIds">
                </form>
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

@section('scripts')
<script src="{{ asset('js/admin-bulk-delete.js') }}"></script>
@endsection
