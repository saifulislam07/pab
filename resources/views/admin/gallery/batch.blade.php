@extends('layouts.admin')

@section('title', 'Batch Gallery Upload')
@section('page_title', 'Batch Gallery Upload')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Upload Multiple Images</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.gallery.batch.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control select2" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Images (Select Multiple) <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="images[]" class="custom-file-input" id="galleryImages" multiple required accept="image/*">
                            <label class="custom-file-label" for="galleryImages">Choose files</label>
                        </div>
                        <small class="form-text text-muted">You can select multiple images. Supported formats: JPG, PNG, WEBP. Max size per image: 5MB.</small>
                        @error('images')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="image-preview-container" class="row mt-3">
                        {{-- Previews will be injected here via JS --}}
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-upload mr-1"></i> Start Upload
                        </button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('galleryImages');
        const container = document.getElementById('image-preview-container');
        const label = document.querySelector('.custom-file-label');

        input.addEventListener('change', function() {
            container.innerHTML = '';
            const files = Array.from(this.files);
            
            if (files.length > 0) {
                label.textContent = `${files.length} files selected`;
            } else {
                label.textContent = 'Choose files';
            }

            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'col-md-3 col-sm-4 col-6 mb-3';
                        div.innerHTML = `
                            <div class="position-relative">
                                <img src="${e.target.result}" class="img-fluid rounded shadow-sm border" style="height: 120px; width: 100%; object-cover: cover;">
                            </div>
                        `;
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>
@endpush
