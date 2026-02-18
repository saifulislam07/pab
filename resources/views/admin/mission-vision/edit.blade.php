@extends('layouts.admin')

@section('title', 'Edit Mission & Vision')
@section('page_title', 'Mission & Vision')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.mission-vision.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h4 class="mb-4">Page Header</h4>
                            <div class="form-group">
                                <label>Page Title</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $content->title ?? '') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Page Subtitle</label>
                                <textarea name="subtitle" class="form-control" rows="2">{{ old('subtitle', $content->subtitle ?? '') }}</textarea>
                            </div>

                            <hr>

                            <h4 class="mt-4 mb-4">Mission Section</h4>
                            <div class="form-group">
                                <label>Mission Title</label>
                                <input type="text" name="mission_title" class="form-control" value="{{ old('mission_title', $content->mission_title ?? '') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Mission Description</label>
                                <textarea name="mission_description" class="form-control" rows="4">{{ old('mission_description', $content->mission_description ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Mission Image</label>
                                <input type="file" name="mission_image" class="form-control-file">
                                @if(isset($content->mission_image))
                                    <div class="mt-2">
                                        <img src="{{ Str::startsWith($content->mission_image, 'http') ? $content->mission_image : asset('storage/' . $content->mission_image) }}" alt="Mission" width="150" class="rounded shadow-sm">
                                    </div>
                                @endif
                                <small class="text-muted">Recommended: 800x600px</small>
                            </div>

                            <div class="form-group" x-data="{ points: {{ Js::from($content->mission_points ?? ['']) }} }">
                                <label>Mission Points</label>
                                <template x-for="(point, index) in points" :key="index">
                                    <div class="input-group mb-2">
                                        <input type="text" name="mission_points[]" x-model="points[index]" class="form-control">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger" @click="points.splice(index, 1)"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" class="btn btn-sm btn-success" @click="points.push('')"><i class="fas fa-plus"></i> Add Point</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4 class="mb-4">Vision Section</h4>
                            <div class="form-group">
                                <label>Vision Title</label>
                                <input type="text" name="vision_title" class="form-control" value="{{ old('vision_title', $content->vision_title ?? '') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Vision Description</label>
                                <textarea name="vision_description" class="form-control" rows="4">{{ old('vision_description', $content->vision_description ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Vision Image</label>
                                <input type="file" name="vision_image" class="form-control-file">
                                @if(isset($content->vision_image))
                                    <div class="mt-2">
                                        <img src="{{ Str::startsWith($content->vision_image, 'http') ? $content->vision_image : asset('storage/' . $content->vision_image) }}" alt="Vision" width="150" class="rounded shadow-sm">
                                    </div>
                                @endif
                                <small class="text-muted">Recommended: 800x600px</small>
                            </div>

                            <div class="form-group" x-data="{ points: {{ Js::from($content->vision_points ?? ['']) }} }">
                                <label>Vision Points</label>
                                <template x-for="(point, index) in points" :key="index">
                                    <div class="input-group mb-2">
                                        <input type="text" name="vision_points[]" x-model="points[index]" class="form-control">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger" @click="points.splice(index, 1)"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" class="btn btn-sm btn-success" @click="points.push('')"><i class="fas fa-plus"></i> Add Point</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Save All Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
