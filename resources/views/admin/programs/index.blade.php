@extends('layouts.admin')

@section('title', 'Programs Management')
@section('page_title', 'Programs Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Programs List</h3>
                <div class="card-tools d-flex align-items-center">
                    @include('admin.partials.search', [
                        'route' => route('admin.programs.index'),
                        'placeholder' => 'Search title or location...',
                        'clearRoute' => route('admin.programs.index')
                    ])
                    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Program
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td>
                                @if($program->image)
                                    <img src="{{ asset('storage/' . $program->image) }}" width="60" class="img-thumbnail rounded shadow-sm">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $program->title }}</td>
                            <td class="align-middle">{{ $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('M d, Y') : 'N/A' }}</td>
                            <td class="align-middle">{{ $program->location }}</td>
                            <td class="align-middle">
                                <span class="badge {{ $program->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $program->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right align-middle">
                                @if($program->is_registration_active)
                                    <a href="{{ route('admin.programs.registrations', $program->id) }}" class="btn btn-sm btn-success" title="Registrations">
                                        <i class="fas fa-users"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.programs.edit', $program->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                            <td colspan="6" class="text-center">No programs found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
