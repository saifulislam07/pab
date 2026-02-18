@extends('layouts.admin')

@section('title', 'My Profile')
@section('page_title', 'My Profile')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Profile Photo Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=128&background=007bff&color=fff' }}"
                         alt="User profile picture"
                         style="width: 128px; height: 128px; object-fit: cover;">
                </div>
                <h3 class="profile-username text-center mt-3">{{ Auth::user()->name }}</h3>
                <p class="text-muted text-center">{{ Auth::user()->email }}</p>
                <p class="text-muted text-center">
                    <span class="badge badge-primary">{{ Auth::user()->roles->pluck('name')->implode(', ') ?: Auth::user()->role }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Edit Profile Card -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3 text-bold">Profile Information</h5>

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3 text-bold">Profile Photo</h5>

                    <div class="form-group">
                        <label for="photo">Upload New Photo</label>
                        <div class="custom-file">
                            <input type="file" name="photo" id="photo" class="custom-file-input" accept="image/*">
                            <label class="custom-file-label" for="photo">Choose file...</label>
                        </div>
                        <small class="text-muted">JPG, PNG, GIF, WEBP — Max 2MB</small>
                    </div>

                    <hr>

                    <h5 class="mb-3 text-bold">Change Password <small class="text-muted">(leave blank to keep current)</small></h5>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save mr-2"></i>Save Changes
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
    // Show selected filename in custom file input
    document.getElementById('photo').addEventListener('change', function() {
        var fileName = this.files[0] ? this.files[0].name : 'Choose file...';
        this.nextElementSibling.textContent = fileName;
    });
</script>
@endsection
