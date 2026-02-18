@extends('layouts.admin')

@section('title', 'Site Settings')
@section('page_title', 'Site Settings')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-3">General Settings</h4>
                            <div class="form-group">
                                <label>Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $setting->site_name ?? '') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Site Title (Browser Tab)</label>
                                <input type="text" name="site_title" class="form-control" value="{{ old('site_title', $setting->site_title ?? '') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Footer Text</label>
                                <textarea name="footer_text" class="form-control" rows="3">{{ old('footer_text', $setting->footer_text ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4 class="mb-3">Images</h4>
                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="logo" class="form-control-file">
                                @if(isset($setting->logo))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" width="100">
                                    </div>
                                @endif
                                <small class="text-muted">Recommended: Transparent PNG, 200x80px</small>
                            </div>
                            <div class="form-group">
                                <label>Favicon</label>
                                <input type="file" name="favicon" class="form-control-file">
                                @if(isset($setting->favicon))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon" width="32">
                                    </div>
                                @endif
                                <small class="text-muted">Recommended: 32x32px .ico or .png</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4 class="mb-3">Contact Information</h4>
                            <div class="form-group">
                                <label>Contact Email</label>
                                <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $setting->contact_email ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Contact Phone</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $setting->contact_phone ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address', $setting->address ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4 class="mb-3">Social Media Links</h4>
                            <div class="form-group">
                                <label>Facebook Link</label>
                                <input type="url" name="facebook_link" class="form-control" value="{{ old('facebook_link', $setting->facebook_link ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Twitter Link</label>
                                <input type="url" name="twitter_link" class="form-control" value="{{ old('twitter_link', $setting->twitter_link ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Instagram Link</label>
                                <input type="url" name="instagram_link" class="form-control" value="{{ old('instagram_link', $setting->instagram_link ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>LinkedIn Link</label>
                                <input type="url" name="linkedin_link" class="form-control" value="{{ old('linkedin_link', $setting->linkedin_link ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Save Site Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
