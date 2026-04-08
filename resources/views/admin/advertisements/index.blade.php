@extends('layouts.admin')

@section('title', 'Advertisements')
@section('page_title', 'Advertisements')

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
                <h3 class="card-title">Advertisements List</h3>
                <div class="card-tools d-flex align-items-center">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mr-2 d-none">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>

                    @include('admin.partials.search', [
                        'route' => route('admin.advertisements.index'),
                        'placeholder' => 'Search advertisements...',
                        'clearRoute' => route('admin.advertisements.index')
                    ])
                    <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-plus"></i> Add Advertisement
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
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($advertisements as $ad)
                        <tr>
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input bulk-checkbox" type="checkbox" id="checkbox-{{ $ad->id }}" value="{{ $ad->id }}">
                                    <label for="checkbox-{{ $ad->id }}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" width="80" class="img-thumbnail">
                            </td>
                            <td class="align-middle">
                                {{ $ad->title }}
                                @if($ad->link)
                                    <br><small class="text-muted"><a href="{{ $ad->link }}" target="_blank">{{ Str::limit($ad->link, 30) }}</a></small>
                                @endif
                            </td>
                            <td class="align-middle"><strong>৳{{ number_format($ad->price, 2) }}</strong></td>
                            <td class="align-middle text-sm">
                                {{ \Carbon\Carbon::parse($ad->start_date)->format('M d, Y') }}<br>
                                <small class="text-muted">to {{ \Carbon\Carbon::parse($ad->end_date)->format('M d, Y') }}</small>
                            </td>
                            <td class="align-middle"><span class="badge badge-info">{{ ucfirst($ad->position) }}</span></td>
                            <td class="align-middle">
                                @if($ad->is_active && $ad->end_date >= now()->toDateString() && $ad->start_date <= now()->toDateString())
                                    <span class="badge badge-success">Active</span>
                                @elseif($ad->end_date < now()->toDateString())
                                    <span class="badge badge-secondary">Expired</span>
                                @elseif($ad->start_date > now()->toDateString())
                                    <span class="badge badge-warning">Scheduled</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="align-middle text-right">
                                <a href="{{ route('admin.advertisements.edit', $ad) }}" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.advertisements.destroy', $ad) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No advertisements found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Bulk Delete Form -->
                <form id="bulkDeleteForm" action="{{ route('admin.advertisements.bulk-destroy') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="ids" id="selectedIds">
                </form>
            </div>
            @if($advertisements->hasPages())
            <div class="card-footer">
                {{ $advertisements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin-bulk-delete.js') }}"></script>
@endsection
