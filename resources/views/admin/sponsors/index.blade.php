@extends('layouts.admin')

@section('title', 'Sponsors Management')
@section('page_title', 'Sponsors Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Sponsors List</h3>
                <div class="card-tools d-flex">
                    <form action="{{ route('admin.sponsors.index') }}" method="GET" class="input-group input-group-sm d-inline-flex mr-2" style="width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Search name..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-danger" title="Clear Search">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                    <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Sponsor
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sponsors as $sponsor)
                        <tr>
                            <td class="align-middle">{{ $sponsor->order }}</td>
                            <td>
                                <img src="{{ \Illuminate\Support\Str::startsWith($sponsor->logo, 'http') ? $sponsor->logo : asset('storage/' . $sponsor->logo) }}" width="80" class="img-thumbnail rounded shadow-sm bg-light">
                            </td>
                            <td class="align-middle">{{ $sponsor->name }}</td>
                            <td class="align-middle"><a href="{{ $sponsor->link }}" target="_blank" class="text-primary">{{ $sponsor->link }}</a></td>
                            <td class="align-middle">
                                <span class="badge {{ $sponsor->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $sponsor->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right align-middle">
                                <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sponsors.destroy', $sponsor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                    {{ $sponsors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
