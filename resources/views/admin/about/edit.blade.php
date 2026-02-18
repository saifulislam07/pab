@extends('layouts.admin')

@section('title', 'Edit About Us')
@section('page_title', 'Edit About Us')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $about->title ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $about->subtitle ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label>Description (Paragraph 1)</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $about->description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Our Story (Paragraph 2)</label>
                        <textarea name="our_story" class="form-control" rows="5" required>{{ old('our_story', $about->our_story ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Mission (Optional)</label>
                        <textarea name="mission" class="form-control" rows="3">{{ old('mission', $about->mission ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Years Active</label>
                                <input type="text" name="stats_years" class="form-control" value="{{ old('stats_years', $about->stats_years ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Members Count</label>
                                <input type="text" name="stats_members" class="form-control" value="{{ old('stats_members', $about->stats_members ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Workshops Count</label>
                                <input type="text" name="stats_workshops" class="form-control" value="{{ old('stats_workshops', $about->stats_workshops ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Awards Won</label>
                                <input type="text" name="stats_awards" class="form-control" value="{{ old('stats_awards', $about->stats_awards ?? '') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Main Image</label>
                                <input type="file" name="image_main" class="form-control-file">
                                <small class="form-text text-muted">Recommended size: 600x400px (or any landscape orientation)</small>
                                @if(isset($about->image_main))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $about->image_main) }}" alt="Main Image" width="150">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Secondary Image</label>
                                <input type="file" name="image_secondary" class="form-control-file">
                                <small class="form-text text-muted">Recommended size: 600x400px (or any landscape orientation)</small>
                                @if(isset($about->image_secondary))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $about->image_secondary) }}" alt="Secondary Image" width="150">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update About Us</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
