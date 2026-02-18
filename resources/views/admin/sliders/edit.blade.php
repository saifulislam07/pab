@extends('layouts.admin')

@section('title', 'Edit Slider')
@section('page_title', 'Edit Slider')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control-file">
                        <div class="mt-2">
                            <img src="{{ Str::startsWith($slider->image, 'http') ? $slider->image : asset('storage/' . $slider->image) }}" width="200">
                        </div>
                        <small class="text-muted">Recommended: 1920x800px. Leave blank to keep current image.</small>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}">
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
                    </div>
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $slider->order) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ $slider->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$slider->is_active ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Slider</button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
