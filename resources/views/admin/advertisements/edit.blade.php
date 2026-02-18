@extends('layouts.admin')

@section('title', 'Edit Advertisement')
@section('page_title', 'Edit Advertisement')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-primary">
            <form action="{{ route('admin.advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Ad Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $advertisement->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Ad Image</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                        @if($advertisement->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $advertisement->image) }}" alt="{{ $advertisement->title }}" width="200" class="img-thumbnail">
                            </div>
                        @endif
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>

                    <div class="form-group">
                        <label>Link URL</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $advertisement->link) }}" placeholder="https://example.com">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Price (৳) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $advertisement->price) }}" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $advertisement->start_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $advertisement->end_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position <span class="text-danger">*</span></label>
                                <select name="position" class="form-control" required>
                                    <option value="sidebar" {{ old('position', $advertisement->position) == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                    <option value="banner" {{ old('position', $advertisement->position) == 'banner' ? 'selected' : '' }}>Banner (Top of page)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-control" required>
                                    <option value="1" {{ old('is_active', $advertisement->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !old('is_active', $advertisement->is_active) ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Advertisement</button>
                    <a href="{{ route('admin.advertisements.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
