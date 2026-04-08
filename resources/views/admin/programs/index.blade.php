@extends('layouts.admin')

@section('title', 'Programs Management')
@section('page_title', 'Programs Management')

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

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
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
                <h3 class="card-title">Programs List</h3>
                <div class="card-tools d-flex align-items-center">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mr-2 d-none">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                    
                    @include('admin.partials.search', [
                        'route' => route('admin.programs.index'),
                        'placeholder' => 'Search title or location...',
                        'clearRoute' => route('admin.programs.index')
                    ])
                    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-plus"></i> Add Program
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
                            <th>Image</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Reg. Deadline</th>
                            <th>Location</th>
                            <th>Sponsors</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input bulk-checkbox" type="checkbox" id="checkbox-{{ $program->id }}" value="{{ $program->id }}">
                                    <label for="checkbox-{{ $program->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                @if($program->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($program->image, 'http') ? $program->image : asset($program->image) }}" width="60" class="img-thumbnail rounded shadow-sm">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $program->title }}</td>
                            <td class="align-middle text-sm text-muted">
                                <strong>Start:</strong> {{ $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('M d, Y') : 'N/A' }}<br>
                                <strong>End:</strong> {{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="align-middle">
                                @if($program->registration_deadline)
                                    <span class="badge {{ \Carbon\Carbon::parse($program->registration_deadline)->isPast() ? 'badge-danger' : 'badge-info' }}">
                                        {{ \Carbon\Carbon::parse($program->registration_deadline)->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">No Deadline</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $program->location }}</td>
                            <td class="align-middle">
                                @if($program->sponsors->count() > 0)
                                    @foreach($program->sponsors as $sponsor)
                                        <span class="badge badge-secondary mb-1" title="{{ $sponsor->name }}">{{ Str::limit($sponsor->name, 15) }}</span><br>
                                    @endforeach
                                @else
                                    <span class="text-muted text-sm">None</span>
                                @endif
                            </td>
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
                            <td colspan="9" class="text-center">No programs found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Bulk Delete Form -->
                <form id="bulkDeleteForm" action="{{ route('admin.programs.bulk-destroy') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="ids" id="selectedIds">
                </form>
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

@section('scripts')
<script src="{{ asset('js/admin-bulk-delete.js') }}"></script>
@endsection
