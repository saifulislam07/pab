@extends('errors.error_layout')

@section('code', '500')
@section('title', 'Server Error')

@section('icon')
<svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
</svg>
@endsection

@section('message')
Whoops! Something went wrong on our end. Our technical team has been notified and is working hard to fix the issue.
@endsection
