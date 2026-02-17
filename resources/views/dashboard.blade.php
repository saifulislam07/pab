@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Welcome</h5>
                <br>
                <p class="card-text">
                    {{ __("You're logged in!") }}
                </p>

                <a href="{{ route('home') }}" class="btn btn-primary">Go to Frontend</a>
            </div>
        </div>
    </div>
</div>
@endsection

