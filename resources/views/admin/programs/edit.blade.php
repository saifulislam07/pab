@extends('layouts.admin')

@section('title', 'Edit Program')
@section('page_title', 'Edit Program')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-primary">
            <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Program Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $program->title }}" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5" required id="summernote">{{ $program->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="file" name="image" class="form-control-file">
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" width="150" class="mt-2 img-thumbnail">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $program->start_date }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $program->end_date }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ $program->location }}" placeholder="e.g. Dhaka, Remote">
                    </div>
                    <div class="form-group">
                        <label>Is Active</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ $program->is_active ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$program->is_active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <hr>
                    <h4 class="mb-3">Registration Settings</h4>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_registration_active" class="custom-control-input" id="is_registration_active" value="1" {{ $program->is_registration_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_registration_active">Enable Registration</label>
                        </div>
                    </div>

                    <div id="registration_details" style="{{ $program->is_registration_active ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label>Registration Fee (0 for free)</label>
                            <input type="number" name="registration_fee" class="form-control" value="{{ $program->registration_fee ?? 0 }}" step="0.01">
                        </div>

                        <div class="form-group">
                            <label>Registration Fields (Information to collect)</label>
                            <div id="fields_container">
                                @if($program->registration_fields && is_array($program->registration_fields))
                                    @foreach($program->registration_fields as $field)
                                        <div class="input-group mb-2 field-row">
                                            <input type="text" name="registration_fields[]" class="form-control" value="{{ $field }}" placeholder="Field Name">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-field"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 field-row">
                                        <input type="text" name="registration_fields[]" class="form-control" placeholder="Field Name (e.g. Full Name)">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-field"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="add_field"><i class="fas fa-plus"></i> Add Field</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Program</button>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#is_registration_active').change(function() {
            if($(this).is(':checked')) {
                $('#registration_details').slideDown();
            } else {
                $('#registration_details').slideUp();
            }
        });

        $('#add_field').click(function() {
            var row = `
                <div class="input-group mb-2 field-row">
                    <input type="text" name="registration_fields[]" class="form-control" placeholder="Field Name">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-field"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            $('#fields_container').append(row);
        });

        $(document).on('click', '.remove-field', function() {
            $(this).closest('.field-row').remove();
        });
    });
</script>
@endpush
