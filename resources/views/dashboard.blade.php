@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="row">
        <!-- Members Summary -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_members'] ?? 0 }}</h3>
                    <p>Total Members</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.members.index', ['status' => 'approved']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending_members'] ?? 0 }}</h3>
                    <p>Pending Approvals</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Events -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['total_events'] ?? 0 }}</h3>
                    <p>Total Events</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ route('admin.events.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Gallery Items -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['total_gallery'] ?? 0 }}</h3>
                    <p>Gallery Items</p>
                </div>
                <div class="icon">
                    <i class="fas fa-images"></i>
                </div>
                <a href="{{ route('admin.gallery.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Earnings -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-maroon">
                <div class="inner">
                    <h3>{{ number_format($stats['total_earnings'] ?? 0, 2) }}</h3>
                    <p>Total Earnings</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="small-box-footer">Cumulative Amount</div>
            </div>
        </div>



        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['total_sponsors'] ?? 0 }}</h3>
                    <p>Sponsors</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="{{ route('admin.sponsors.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
