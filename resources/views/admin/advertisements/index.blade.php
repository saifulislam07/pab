@extends('layouts.admin')

@section('title', 'Advertisements')
@section('page_title', 'Advertisements')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Advertisement
        </a>
    </div>
    <div class="col-md-6">
        <form action="{{ route('admin.advertisements.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search advertisements..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-danger"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
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
                    <td>
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" width="80" class="img-thumbnail">
                    </td>
                    <td>
                        {{ $ad->title }}
                        @if($ad->link)
                            <br><small class="text-muted"><a href="{{ $ad->link }}" target="_blank">{{ Str::limit($ad->link, 30) }}</a></small>
                        @endif
                    </td>
                    <td><strong>৳{{ number_format($ad->price, 2) }}</strong></td>
                    <td>
                        {{ \Carbon\Carbon::parse($ad->start_date)->format('M d, Y') }}<br>
                        <small class="text-muted">to {{ \Carbon\Carbon::parse($ad->end_date)->format('M d, Y') }}</small>
                    </td>
                    <td><span class="badge badge-info">{{ ucfirst($ad->position) }}</span></td>
                    <td>
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
                    <td>
                        <a href="{{ route('admin.advertisements.edit', $ad) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.advertisements.destroy', $ad) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No advertisements found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($advertisements->hasPages())
    <div class="card-footer">
        {{ $advertisements->links() }}
    </div>
    @endif
</div>
@endsection
