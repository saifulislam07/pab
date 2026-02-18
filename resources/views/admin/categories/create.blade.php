@extends('layouts.admin')

@section('title', 'Add Category')
@section('page_title', 'Add Category')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
