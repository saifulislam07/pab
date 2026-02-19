@extends('layouts.admin')

@section('title', 'Member Dashboard')
@section('page_title', 'Member Dashboard')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-md-8 pb-2">
        <div class="card card-outline card-primary h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-hand-wave mr-1 text-primary"></i> Welcome, {{ auth()->user()->name }}!</h3>
            </div>
            <div class="card-body">
                <p class="lead">Welcome to your PAB Member Dashboard.</p>
                <p>Here you can manage your profile, view upcoming events, and access community resources. We are glad to have you as part of our professional community.</p>
                
                @if($member && $member->status == 'pending')
                    <div class="alert alert-warning mt-4">
                        <h5 class="mb-2"><i class="icon fas fa-exclamation-triangle"></i> Membership Status: Pending</h5>
                        Your membership status is currently <strong>Pending</strong>. Some features may be restricted until approved by an administrator.
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('member.profile.edit') }}" class="btn btn-primary mr-2">
                        <i class="fas fa-user-edit mr-1"></i> Update Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ID Card -->
    <div class="col-md-4 pb-2">
        <div class="card card-outline card-danger h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-id-card mr-1 text-danger"></i> Digital ID Card</h3>
            </div>
            <div class="card-body text-center">
                <!-- Digital ID Card Container -->
                <div id="id-card-capture" class="mb-3 mx-auto" style="max-width: 350px;">
                    <div class="p-4 rounded-xl shadow-lg relative overflow-hidden text-left" 
                         style="background: linear-gradient(135deg, #1a1a1a 0%, #3d0000 100%); min-height: 220px; border: 1px solid #444; border-radius: 15px; position: relative;">
                        
                        <!-- Decorative Pattern Overlay -->
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px; opacity: 0.05; pointer-events: none;"></div>

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3" style="position: relative; z-index: 1;">
                            <span class="text-white font-weight-bold" style="letter-spacing: 1px; font-size: 0.7rem;">
                                <i class="fas fa-camera-retro mr-1 text-danger"></i> PAB MEMBER
                            </span>
                        </div>

                        <div class="row no-gutters" style="position: relative; z-index: 1;">
                            <div class="col-4">
                                <div class="rounded overflow-hidden border border-secondary bg-dark shadow-sm" style="height: 80px; width: 80px;">
                                    <img src="{{ $member->image ? asset('storage/' . $member->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}" 
                                         class="img-fluid" 
                                         style="width: 100%; height: 100%; object-fit: cover;"
                                         alt="{{ auth()->user()->name }}"
                                         crossorigin="anonymous">
                                </div>
                            </div>
                            <div class="col-8 pl-3">
                                <h6 class="text-white mb-0 text-truncate font-weight-bold" style="font-size: 0.95rem;">{{ auth()->user()->name }}</h6>
                                <p class="text-danger mb-2" style="font-size: 0.7rem; line-height: 1.2;">{{ $member->title ?? 'Professional Photographer' }}</p>
                                
                                <div class="mt-2">
                                    <small class="text-muted d-block uppercase" style="font-size: 0.55rem; letter-spacing: 1px;">MEMBER ID</small>
                                    <span class="text-white font-mono" style="font-family: monospace; font-size: 0.9rem; letter-spacing: 1.5px;">
                                        {{ $member->member_id ?? 'PAB-' . str_pad($member->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-4 pt-2 border-top border-secondary opacity-50 d-flex justify-content-between align-items-center" style="position: relative; z-index: 1;">
                            <small class="text-white italic" style="font-size: 0.6rem;">PAB Official Membership</small>
                            <i class="fas fa-certificate text-danger" style="font-size: 0.7rem;"></i>
                        </div>

                        <!-- Background Icon Overlay -->
                        <i class="fas fa-camera" style="position: absolute; right: -15px; bottom: -15px; font-size: 110px; opacity: 0.05; color: white; transform: rotate(-15deg); pointer-events: none;"></i>
                    </div>
                </div>

                <!-- Download Button -->
                @if($member->status == 'approved')
                <div class="mx-auto" style="max-width: 350px;">
                    <button id="download-btn" class="btn btn-block btn-success shadow-sm btn-sm">
                        <i class="fas fa-download mr-1"></i> Download ID Card (PNG)
                    </button>
                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-block btn-outline-info btn-sm mt-2">
                        <i class="fas fa-eye mr-1"></i> View Public Profile
                    </a>
                </div>
                @else
                <div class="mx-auto text-center mt-3" style="max-width: 350px;">
                    <p class="text-muted small italic">ID Card download will be available once your membership is approved.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Community Size -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_approved_members'] }}</h3>
                <p>Approved Members</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('members') }}" class="small-box-footer">View Community <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['upcoming_events'] }}</h3>
                <p>Upcoming Events</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="{{ route('events.index') }}" class="small-box-footer">View Events <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Gallery -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-gray">
            <div class="inner">
                <h3>{{ $stats['total_gallery'] }}</h3>
                <p>Gallery Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-images"></i>
            </div>
            <a href="{{ route('gallery') }}" class="small-box-footer">View Gallery <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const downloadBtn = document.getElementById('download-btn');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const btn = this;
                const card = document.getElementById('id-card-capture');
                
                if (btn.disabled) return;

                btn.disabled = true;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Processing...';

                // Use a slight timeout to ensure UI state is updated
                setTimeout(() => {
                    html2canvas(card, {
                        scale: 3,
                        useCORS: true, 
                        allowTaint: false, // Set to false when useCORS is true
                        backgroundColor: '#1a1a1a', // Set explicit background
                        logging: true, // Enable for debugging
                        width: card.offsetWidth,
                        height: card.offsetHeight
                    }).then(canvas => {
                        const dataUrl = canvas.toDataURL('image/png');
                        const link = document.createElement('a');
                        link.style.display = 'none';
                        link.href = dataUrl;
                        link.download = 'PAB-Member-ID.png';
                        
                        document.body.appendChild(link);
                        link.click();
                        
                        setTimeout(() => {
                            document.body.removeChild(link);
                        }, 100);

                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }).catch(err => {
                        console.error('ID Card capture error:', err);
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        alert('Error generating card image. Please try again.');
                    });
                }, 100);
            });
        }
    });
</script>
@endsection
