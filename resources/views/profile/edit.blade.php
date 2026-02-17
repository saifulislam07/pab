@extends('layouts.admin')

@section('title', 'Profile')
@section('page_title', 'Profile Settings')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ __('Update Profile Information') }}</h3>
            </div>
            <div class="card-body">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ __('Update Password') }}</h3>
            </div>
            <div class="card-body">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ __('Delete Account') }}</h3>
            </div>
            <div class="card-body">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

