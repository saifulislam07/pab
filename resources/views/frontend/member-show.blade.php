@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8 animate-fade-in">
            <a href="{{ route('members') }}" class="text-gray-400 hover:text-white flex items-center transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Members
            </a>
        </div>

        <div class="bg-gray-800 rounded-3xl overflow-hidden shadow-2xl animate-fade-in">
            <!-- Header/Cover Area -->
            <div class="h-48 bg-gradient-to-r from-red-600 to-red-900"></div>
            
            <div class="relative px-8 pb-8">
                <!-- Profile Image -->
                <div class="relative -mt-24 mb-6 inline-block">
                    <div class="w-48 h-48 rounded-2xl overflow-hidden border-8 border-gray-800 bg-gray-700 shadow-xl">
                        <img src="{{ $member->image ? asset('storage/' . $member->image) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&size=200' }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Personal Info -->
                    <div class="lg:col-span-2">
                        <h1 class="text-4xl font-bold text-white mb-2">{{ $member->name }}</h1>
                        <p class="text-xl text-red-500 font-medium mb-4">{{ $member->title }} {{ $member->profession ? '• ' . $member->profession : '' }}</p>
                        
                        @if($member->bio)
                        <div class="mb-8">
                            <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest mb-3">About Me</h3>
                            <p class="text-gray-300 leading-relaxed text-lg">{{ $member->bio }}</p>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Photography Details -->
                            <div>
                                <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest mb-4 border-b border-gray-700 pb-2">Photography</h3>
                                <div class="space-y-4">
                                    @if($member->specialization)
                                    <div>
                                        <label class="block text-gray-500 text-xs mb-1">Specialization</label>
                                        <span class="text-white">{{ $member->specialization }}</span>
                                    </div>
                                    @endif
                                    @if($member->experience_level)
                                    <div>
                                        <label class="block text-gray-500 text-xs mb-1">Experience Level</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">
                                            {{ $member->experience_level }}
                                        </span>
                                    </div>
                                    @endif
                                    @if($member->camera_gear)
                                    <div>
                                        <label class="block text-gray-500 text-xs mb-1">Camera Gear</label>
                                        <span class="text-gray-300 italic text-sm">{{ $member->camera_gear }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Practical Info -->
                            <div>
                                <h3 class="text-gray-400 uppercase text-xs font-bold tracking-widest mb-4 border-b border-gray-700 pb-2">Location & ID</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-gray-500 text-xs mb-1">Permanent Address</label>
                                        <p class="text-white text-sm">
                                            {{ $member->upazila ? $member->upazila . ', ' : '' }}
                                            {{ $member->district }}, {{ $member->division }}
                                        </p>
                                    </div>
                                    @if($member->current_location)
                                    <div>
                                        <label class="block text-gray-500 text-xs mb-1">Currently Located In</label>
                                        <span class="text-white">{{ $member->current_location }}</span>
                                    </div>
                                    @endif
                                    @if($member->member_id)
                                    <div>
                                        <label class="block text-gray-500 text-xs mb-1">Member ID</label>
                                        <code class="bg-gray-900 text-red-500 px-2 py-1 rounded text-sm font-mono">{{ $member->member_id }}</code>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Contact & Social -->
                    <div class="space-y-8">
                        @if($member->permission)
                        <div class="bg-gray-900 p-6 rounded-2xl border border-gray-700">
                            <h3 class="text-white font-bold mb-4 flex items-center">
                                <i class="fas fa-address-card mr-2 text-red-500"></i> Contact Information
                            </h3>
                            <div class="space-y-4">
                                <a href="mailto:{{ $member->email }}" class="flex items-center text-gray-400 hover:text-white transition group">
                                    <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-900 transition">
                                        <i class="fas fa-envelope text-red-500"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs text-gray-500">Email Address</span>
                                        <span class="break-all">{{ $member->email }}</span>
                                    </div>
                                </a>
                                <a href="tel:{{ $member->mobile }}" class="flex items-center text-gray-400 hover:text-white transition group">
                                    <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-900 transition">
                                        <i class="fas fa-phone text-red-500"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs text-gray-500">Phone Number</span>
                                        <span>{{ $member->mobile }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="bg-gray-900 p-6 rounded-2xl border border-gray-800 text-center opacity-60">
                            <i class="fas fa-lock text-gray-600 mb-2"></i>
                            <p class="text-gray-500 text-xs italic">Contact information is private</p>
                        </div>
                        @endif

                        <!-- Social Links -->
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                            @if($member->facebook)
                            <a href="{{ $member->facebook }}" target="_blank" class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition shadow-lg">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            @endif
                            @if($member->instagram)
                            <a href="{{ $member->instagram }}" target="_blank" class="w-12 h-12 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition shadow-lg">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            @endif
                            @if($member->linkedin)
                            <a href="{{ $member->linkedin }}" target="_blank" class="w-12 h-12 bg-blue-800 text-white rounded-full flex items-center justify-center hover:bg-blue-900 transition shadow-lg">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                            @endif
                            @if($member->website)
                            <a href="{{ $member->website }}" target="_blank" class="w-12 h-12 bg-gray-600 text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition shadow-lg">
                                <i class="fas fa-globe text-lg"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
</style>
@endsection
