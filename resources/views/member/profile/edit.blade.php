@extends('layouts.admin')

@section('title', 'Complete Your Profile')
@section('page_title', 'Complete Your Profile')

@section('content')
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Welcome to PAB!</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">To get started, please provide a few more details about yourself. This helps our community connect with you.</p>

                        @php
    $percentage = $member->getCompletionPercentage();
    $barClass = $percentage < 50 ? 'bg-danger' : ($percentage < 100 ? 'bg-warning' : 'bg-success');
                        @endphp

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold">Profile Completion</span>
                                <span class="badge {{ $barClass }}">{{ $percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated {{ $barClass }}"
                                     role="progressbar"
                                     style="width: {{ $percentage }}%;"
                                     aria-valuenow="{{ $percentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                            @if($percentage < 100)
                                <small class="text-muted mt-1 d-block">Required: name, mobile, email, title, profession, photo, bio, address details, and photography info.</small>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Personal Info --}}
                            <h5 class="mb-3"><i class="fas fa-user mr-2"></i> Personal Information</h5>

                            @if($member->member_id)
                            <div class="form-group">
                                <label>Member ID</label>
                                <input type="text" class="form-control bg-light" value="{{ $member->member_id }}" readonly>
                                <small class="text-muted">Your unique member ID (auto-generated, cannot be changed)</small>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}"
                                            class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Title / Designation</label>
                                        <input type="text" name="title" id="title" value="{{ old('title', $member->title) }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="e.g. Lead Photographer">
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="profession">Profession</label>
                                        <input type="text" name="profession" id="profession" value="{{ old('profession', $member->profession) }}"
                                            class="form-control @error('profession') is-invalid @enderror"
                                            placeholder="e.g. Software Engineer, Teacher">
                                        @error('profession')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $member->mobile) }}"
                                            class="form-control @error('mobile') is-invalid @enderror"
                                            required placeholder="+880 1XXX-XXXXXX">
                                        @error('mobile')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="permission" class="custom-control-input" id="permission" value="1" {{ old('permission', $member->permission) ? 'checked' : '' }}>
                                    <label class="custom-control-label text-danger" for="permission">Allow my email and phone number to be visible on the public
                                        members list</label>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    @if($member->image)
                                        <img src="{{ asset('storage/' . $member->image) }}" alt="Profile"
                                            class="img-circle elevation-2" style="width: 80px; height: 80px; object-fit: cover;">
                                        <br><small class="text-muted">Current Photo</small>
                                    @else
                                        <div class="img-circle bg-secondary d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 80px; height: 80px;">
                                            <i class="fas fa-user fa-2x text-white"></i>
                                        </div>
                                        <br><small class="text-muted">No photo yet</small>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group mb-0">
                                        <label for="image">Change Profile Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="image" class="custom-file-input">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <textarea name="bio" id="bio" rows="3"
                                    class="form-control"
                                    placeholder="Tell us a bit about your photography interest...">{{ old('bio', $member->bio) }}</textarea>
                            </div>

                            {{-- Permanent Address --}}
                            <hr>
                            <h5 class="mb-3"><i class="fas fa-map-marker-alt mr-2"></i> Permanent Address</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="division">Division</label>
                                        <select name="division" id="division" class="form-control @error('division') is-invalid @enderror">
                                            <option value="">-- Select Division --</option>
                                            @foreach(['Barishal', 'Chittagong', 'Dhaka', 'Khulna', 'Mymensingh', 'Rajshahi', 'Rangpur', 'Sylhet'] as $div)
                                                <option value="{{ $div }}" {{ old('division', $member->division) == $div ? 'selected' : '' }}>{{ $div }}</option>
                                            @endforeach
                                        </select>
                                        @error('division')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select name="district" id="district" class="form-control @error('district') is-invalid @enderror">
                                            <option value="">-- Select District --</option>
                                        </select>
                                        @error('district')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upazila">Upazila / Thana</label>
                                        <input type="text" name="upazila" id="upazila" value="{{ old('upazila', $member->upazila) }}"
                                            class="form-control @error('upazila') is-invalid @enderror"
                                            placeholder="e.g. Dhanmondi">
                                        @error('upazila')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="current_location">Current Location</label>
                                <input type="text" name="current_location" id="current_location" value="{{ old('current_location', $member->current_location) }}"
                                    class="form-control @error('current_location') is-invalid @enderror"
                                    placeholder="Where you currently live / work">
                                @error('current_location')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Photography Details --}}
                            <hr>
                            <h5 class="mb-3"><i class="fas fa-camera mr-2"></i> Photography Details</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="specialization">Specialization</label>
                                        <select name="specialization" id="specialization" class="form-control @error('specialization') is-invalid @enderror">
                                            <option value="">-- Select Specialization --</option>
                                            @foreach(['Wedding', 'Wildlife', 'Fashion', 'Sports', 'Street', 'Portrait', 'Landscape', 'Event', 'Product', 'Architectural'] as $spec)
                                                <option value="{{ $spec }}" {{ old('specialization', $member->specialization) == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                            @endforeach
                                        </select>
                                        @error('specialization')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="experience_level">Experience Level</label>
                                        <select name="experience_level" id="experience_level" class="form-control @error('experience_level') is-invalid @enderror">
                                            <option value="">-- Select Level --</option>
                                            @foreach(['Professional', 'Intermediate', 'Hobbyist'] as $level)
                                                <option value="{{ $level }}" {{ old('experience_level', $member->experience_level) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                            @endforeach
                                        </select>
                                        @error('experience_level')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="camera_gear">Camera Gear</label>
                                <textarea name="camera_gear" id="camera_gear" rows="2"
                                    class="form-control @error('camera_gear') is-invalid @enderror"
                                    placeholder="e.g. Canon EOS R5, Sony A7III, 24-70mm f/2.8 ...">{{ old('camera_gear', $member->camera_gear) }}</textarea>
                                @error('camera_gear')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Permission --}}


                            {{-- Social Links --}}
                            <hr>
                            <h5 class="mb-3"><i class="fas fa-share-alt mr-2"></i> Social Links (Optional)</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook URL</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                            </div>
                                            <input type="url" name="facebook" value="{{ old('facebook', $member->facebook) }}"
                                                class="form-control" placeholder="https://facebook.com/username">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Instagram URL</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            </div>
                                            <input type="url" name="instagram" value="{{ old('instagram', $member->instagram) }}"
                                                class="form-control" placeholder="https://instagram.com/username">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>LinkedIn URL</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            </div>
                                            <input type="url" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}"
                                                class="form-control" placeholder="https://linkedin.com/in/username">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Personal Website</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            </div>
                                            <input type="url" name="website" value="{{ old('website', $member->website) }}"
                                                class="form-control" placeholder="https://yourwebsite.com">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-danger btn-lg elevation-2">
                                    <i class="fas fa-save mr-2"></i> Complete Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
    // Custom file input show filename
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Cascading Division → District dropdown
    var savedDistrict = "{{ old('district', $member->district) }}";

    function loadDistricts(division, selected) {
        var $district = $('#district');
        $district.html('<option value="">Loading...</option>');
        if (!division) {
            $district.html('<option value="">-- Select District --</option>');
            return;
        }
        $.getJSON('/api/districts/' + encodeURIComponent(division), function(data) {
            var options = '<option value="">-- Select District --</option>';
            $.each(data, function(i, name) {
                var sel = (name === selected) ? ' selected' : '';
                options += '<option value="' + name + '"' + sel + '>' + name + '</option>';
            });
            $district.html(options);
        });
    }

    $('#division').on('change', function() {
        loadDistricts($(this).val(), '');
    });

    // On page load, pre-populate if division is already set
    var initialDivision = $('#division').val();
    if (initialDivision) {
        loadDistricts(initialDivision, savedDistrict);
    }
</script>
@endsection
