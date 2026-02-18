@extends('layouts.admin')

@section('title', 'Add Sponsor')
@section('page_title', 'Add Sponsor')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Sponsor Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control-file" required>
                    </div>
                    <div class="form-group">
                        <label>Website Link (Optional)</label>
                        <input type="url" name="link" class="form-control" placeholder="https://example.com">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Order</label>
                                <input type="number" name="order" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Is Active</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Sponsor</button>
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
