@extends('layouts.admin')

@section('title', 'Add Program')
@section('page_title', 'Add Program')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-primary">
            <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="required-label">Program Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="required-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required id="summernote">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger text-sm"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Banner Image</label>
                        <input type="file" name="image" class="form-control-file" id="image_input">
                        <div id="image_preview" class="mt-2" style="display: none;">
                            <img src="#" alt="Preview" width="150" class="img-thumbnail" id="preview_img">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Registration Deadline</label>
                                <input type="date" name="registration_deadline" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Dhaka, Remote">
                    </div>
                    <div class="form-group">
                        <label>Sponsor (Optional - Multiple allowed)</label>
                        <select name="sponsor_ids[]" class="form-control" multiple>
                            @foreach($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold CTRL (Windows) or CMD (Mac) to select multiple.</small>
                    </div>
                    <div class="form-group">
                        <label class="required-label">Is Active</label>
                        <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_active')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <hr>
                    <h4 class="mb-3">Registration Settings</h4>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_registration_active" class="custom-control-input" id="is_registration_active" value="1">
                            <label class="custom-control-label" for="is_registration_active">Enable Registration</label>
                        </div>
                    </div>

                    <div id="registration_details" style="display: none;">
                        <div class="form-group">
                            <label>Registration Fee (0 for free)</label>
                            <input type="number" name="registration_fee" class="form-control" value="0" step="0.01">
                        </div>

                        <div class="form-group">
                            <label>Registration Fields (Information to collect)</label>
                            <div id="fields_container">
                                <div class="row align-items-center mb-2 field-row">
                                    <div class="col-md-5">
                                        <input type="text" name="registration_fields[0][name]" class="form-control" placeholder="Field Name (e.g. Full Name)" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="registration_fields[0][type]" class="form-control">
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                            <option value="email">Email</option>
                                            <option value="date">Date</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="photo">Photo / File</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox pt-2">
                                            <input type="checkbox" name="registration_fields[0][required]" class="custom-control-input" id="required_0" value="1" checked>
                                            <label class="custom-control-label" for="required_0">Required</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <button type="button" class="btn btn-danger remove-field"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="add_field"><i class="fas fa-plus"></i> Add Field</button>
                            <small class="form-text text-muted">Example: Full Name (Text), Phone (Number), Photo (File)</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Program</button>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        // Image Preview logic
        $('#image_input').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview_img').attr('src', event.target.result);
                    $('#image_preview').show();
                }
                reader.readAsDataURL(file);
            }
        });

        // Initialize Summernote
        $('#summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        var fieldIndex = 1;

        function toggleRegistrationRequired(isActive) {
            $('#registration_details').find('input, select, textarea').each(function() {
                if ($(this).attr('name') && $(this).attr('name').includes('registration_fields') && $(this).attr('name').includes('[name]')) {
                    if (isActive) {
                        $(this).prop('required', true);
                    } else {
                        $(this).prop('required', false);
                    }
                }
            });
        }

        $('#is_registration_active').change(function() {
            if($(this).is(':checked')) {
                $('#registration_details').slideDown();
                toggleRegistrationRequired(true);
            } else {
                $('#registration_details').slideUp();
                toggleRegistrationRequired(false);
            }
        });

        // Initialize state
        toggleRegistrationRequired($('#is_registration_active').is(':checked'));

        $('#add_field').click(function() {
            var isRequired = $('#is_registration_active').is(':checked') ? 'required' : '';
            var row = `
                <div class="row align-items-center mb-2 field-row">
                    <div class="col-md-5">
                        <input type="text" name="registration_fields[${fieldIndex}][name]" class="form-control" placeholder="Field Name" ${isRequired}>
                    </div>
                    <div class="col-md-3">
                        <select name="registration_fields[${fieldIndex}][type]" class="form-control">
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="textarea">Textarea</option>
                            <option value="photo">Photo / File</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox pt-2">
                            <input type="checkbox" name="registration_fields[${fieldIndex}][required]" class="custom-control-input" id="required_${fieldIndex}" value="1" checked>
                            <label class="custom-control-label" for="required_${fieldIndex}">Required</label>
                        </div>
                    </div>
                    <div class="col-md-1 text-right">
                        <button type="button" class="btn btn-danger remove-field"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            $('#fields_container').append(row);
            fieldIndex++;
        });

        $(document).on('click', '.remove-field', function() {
            $(this).closest('.field-row').remove();
        });
    });
</script>
@endsection
