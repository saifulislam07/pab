@extends('layouts.admin')

@section('title', 'Sliders')
@section('page_title', 'Sliders')

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
                <h3 class="card-title">All Sliders</h3>
                <div class="card-tools d-flex align-items-center">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mr-2 d-none">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>

                    @include('admin.partials.search', [
                        'route' => route('admin.sliders.index'),
                        'placeholder' => 'Search title...',
                        'clearRoute' => route('admin.sliders.index')
                    ])
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-plus"></i> Add New Slider
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
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $slider)
                        <tr>
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input bulk-checkbox" type="checkbox" id="checkbox-{{ $slider->id }}" value="{{ $slider->id }}">
                                    <label for="checkbox-{{ $slider->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                <img src="{{ Str::startsWith($slider->image, 'http') ? $slider->image : asset('storage/' . $slider->image) }}" width="120" class="img-thumbnail rounded shadow-sm">
                            </td>
                            <td class="align-middle font-weight-bold">{{ $slider->title }}</td>
                            <td class="align-middle">{{ $slider->order }}</td>
                            <td class="align-middle">
                                <span class="badge badge-{{ $slider->is_active ? 'success' : 'danger' }}">
                                    {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right align-middle">
                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-info btn-sm text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Bulk Delete Form -->
                <form id="bulkDeleteForm" action="{{ route('admin.sliders.bulk-destroy') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="ids" id="selectedIds">
                </form>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $sliders->links() ?? '' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin-bulk-delete.js') }}"></script>
@endsection
