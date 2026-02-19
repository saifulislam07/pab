@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">All Roles</h3>
                <div class="card-tools d-flex align-items-center">
                    @include('admin.partials.search', [
                        'route' => route('admin.roles.index'),
                        'placeholder' => 'Search role name...',
                        'clearRoute' => route('admin.roles.index')
                    ])
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Create New Role
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <span class="badge badge-info">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-info text-white" title="Edit Role">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(!in_array($role->name, ['admin', 'member']))
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline ml-1" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Role">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
