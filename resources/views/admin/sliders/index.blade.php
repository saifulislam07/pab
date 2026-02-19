@extends('layouts.admin')

@section('title', 'Sliders')
@section('page_title', 'Sliders')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">All Sliders</h3>
                <div class="card-tools d-flex align-items-center">
                    @include('admin.partials.search', [
                        'route' => route('admin.sliders.index'),
                        'placeholder' => 'Search title...',
                        'clearRoute' => route('admin.sliders.index')
                    ])
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New Slider
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
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
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{-- Assuming pagination exists here, though sliders often don't have many --}}
                    {{ $sliders->links() ?? '' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
