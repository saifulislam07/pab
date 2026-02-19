@extends('layouts.admin')

@section('title', 'Edit Team Member')
@section('page_title', 'Edit Team Member')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <form action="{{ route('admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $team->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" class="form-control" value="{{ $team->role }}" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control-file">
                        @if($team->image)
                            <img src="{{ asset('storage/' . $team->image) }}" width="100" class="mt-2 img-thumbnail">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Facebook URL</label>
                                <input type="url" name="facebook" class="form-control" value="{{ $team->facebook }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Instagram URL</label>
                                <input type="url" name="instagram" class="form-control" value="{{ $team->instagram }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>LinkedIn URL</label>
                                <input type="url" name="linkedin" class="form-control" value="{{ $team->linkedin }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website URL</label>
                                <input type="url" name="website" class="form-control" value="{{ $team->website }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Order</label>
                                <input type="number" name="order" class="form-control" value="{{ $team->order }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Is Active</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $team->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$team->is_active ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Member</button>
                    <a href="{{ route('admin.team.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
