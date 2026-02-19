@extends('layouts.admin')

@section('title', 'Gallery Management')
@section('page_title', 'Gallery Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">All Gallery Items</h3>
                <div class="card-tools d-flex align-items-center">
                    @include('admin.partials.search', [
                        'route' => route('admin.gallery.index'),
                        'placeholder' => 'Search title...',
                        'clearRoute' => route('admin.gallery.index')
                    ])
                    <a href="{{ route('admin.gallery.batch') }}" class="btn btn-info btn-sm mr-2 text-white">
                        <i class="fas fa-layer-group"></i> Batch Upload
                    </a>
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New Item
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" width="80" class="img-thumbnail rounded shadow-sm">
                            </td>
                            <td class="align-middle">{{ $item->title ?? 'N/A' }}</td>
                            <td class="align-middle"><span class="badge badge-info">{{ $item->category->name ?? 'Uncategorized' }}</span></td>
                            <td class="text-right align-middle">
                                <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
