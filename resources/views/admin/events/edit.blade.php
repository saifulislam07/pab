@extends('layouts.admin')

@section('title', 'Edit Event')
@section('page_title', 'Edit Event')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-primary">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Event Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5" required id="summernote">{{ $event->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="file" name="image" class="form-control-file">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" width="150" class="mt-2 img-thumbnail">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $event->start_date }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $event->end_date }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ $event->location }}" placeholder="e.g. Dhaka, Remote">
                    </div>
                    <div class="form-group">
                        <label>Is Active</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ $event->is_active ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$event->is_active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
