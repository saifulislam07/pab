@extends('layouts.admin')

@section('title', 'Edit Gallery Item')
@section('page_title', 'Edit Gallery Item')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Title (Optional)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $gallery->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control-file">
                        <div class="mt-2">
                            <img src="{{ Str::startsWith($gallery->image, 'http') ? $gallery->image : asset('storage/' . $gallery->image) }}" width="150" class="img-thumbnail">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Item</button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
