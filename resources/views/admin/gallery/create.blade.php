@extends('layouts.admin')

@section('title', 'Add Gallery Item')
@section('page_title', 'Add Gallery Item')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title (Optional)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control-file" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Item</button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
