@extends('layouts.admin')

@section('title', 'Edit Sponsor')
@section('page_title', 'Edit Sponsor')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <form action="{{ route('admin.sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Sponsor Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $sponsor->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control-file">
                        <img src="{{ \Illuminate\Support\Str::startsWith($sponsor->logo, 'http') ? $sponsor->logo : asset('storage/' . $sponsor->logo) }}" width="100" class="mt-2 img-thumbnail">
                    </div>
                    <div class="form-group">
                        <label>Website Link (Optional)</label>
                        <input type="url" name="link" class="form-control" value="{{ $sponsor->link }}" placeholder="https://example.com">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Order</label>
                                <input type="number" name="order" class="form-control" value="{{ $sponsor->order }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Is Active</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $sponsor->is_active ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$sponsor->is_active ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Sponsor</button>
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
