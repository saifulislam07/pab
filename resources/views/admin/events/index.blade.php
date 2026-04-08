@extends('layouts.admin')

@section('title', 'Events Management')
@section('page_title', 'Events Management')

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
                <h3 class="card-title">Events List</h3>
                <div class="card-tools d-flex align-items-center">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mr-2 d-none">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                    
                    @include('admin.partials.search', [
                        'route' => route('admin.events.index'),
                        'placeholder' => 'Search title or location...',
                        'clearRoute' => route('admin.events.index')
                    ])
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-plus"></i> Add Event
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
                            <th>Location</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input bulk-checkbox" type="checkbox" id="checkbox-{{ $event->id }}" value="{{ $event->id }}">
                                    <label for="checkbox-{{ $event->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                @if($event->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($event->image, 'http') ? $event->image : asset($event->image) }}" width="60" class="img-thumbnail rounded shadow-sm">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $event->title }}</td>
                            <td class="align-middle">{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('M d, Y') : 'N/A' }}</td>
                            <td class="align-middle">{{ $event->location }}</td>
                            <td class="align-middle">
                                <span class="badge {{ $event->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $event->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right align-middle">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                <form id="bulkDeleteForm" action="{{ route('admin.events.bulk-destroy') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="ids" id="selectedIds">
                </form>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin-bulk-delete.js') }}"></script>
@endsection
