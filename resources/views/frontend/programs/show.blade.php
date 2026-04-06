@extends('layouts.frontend')

@section('title', $program->title)

@section('content')
<div class="bg-gray-900 py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <a href="{{ route('programs.index') }}" class="inline-flex items-center text-red-500 hover:text-red-400 mb-8 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to All Programs
        </a>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Main Content --}}
            <div class="flex-1">
                @if($program->image)
                    <img src="{{ Str::startsWith($program->image, ['http://', 'https://']) ? $program->image : asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-auto rounded-xl shadow-2xl mb-12 animate-fade-in shadow-red-900/10 border border-gray-800">
                @endif

                <div class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl overflow-hidden relative">
                    <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-400">
                        <span class="flex items-center bg-gray-900/50 px-3 py-1 rounded-full border border-gray-700">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($program->start_date)->format('F d, Y') }}
                        </span>
                        @if($program->location)
                        <span class="flex items-center bg-gray-900/50 px-3 py-1 rounded-full border border-gray-700">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $program->location }}
                        </span>
                        @endif
                    </div>

                    <h1 class="text-4xl font-extrabold text-white mb-8 border-b border-gray-700 pb-6">{{ $program->title }}</h1>
                    
                    <div class="prose prose-invert prose-red max-w-none text-gray-300 leading-relaxed summernote-content text-lg mb-12">
                        {!! $program->description !!}
                    </div>

                    {{-- Registration Form --}}
                    @if($program->is_registration_active)
                        <div class="mt-12 bg-gray-900/80 p-8 rounded-xl border border-red-500/20 shadow-2xl relative">
                            <div class="absolute top-0 right-0 p-4 opacity-5">
                                <i class="fas fa-edit text-8xl text-red-500"></i>
                            </div>
                            
                            <h2 class="text-3xl font-bold text-white mb-8 flex items-center">
                                <span class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-red-600/30">
                                    <i class="fas fa-file-signature text-sm"></i>
                                </span>
                                Register for {{ $program->title }}
                            </h2>

                            @if(session('success'))
                                <div class="bg-green-500/10 border border-green-500/50 text-green-400 p-6 rounded-xl mb-8 flex items-center animate-bounce-subtle">
                                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-semibold">{{ session('success') }}</span>
                                </div>
                            @endif

                            <form action="{{ route('programs.register', $program->slug) }}" method="POST" class="space-y-8">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    @if($program->registration_fields)
                                        @foreach($program->registration_fields as $field)
                                            @php $fieldName = str_replace(' ', '_', strtolower($field)); @endphp
                                            <div class="space-y-3">
                                                <label for="{{ $fieldName }}" class="block text-sm font-bold text-gray-400 tracking-wider uppercase">{{ $field }} <span class="text-red-500">*</span></label>
                                                <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" required
                                                    class="w-full bg-gray-800/50 border border-gray-700 rounded-xl py-4 px-5 text-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-300 placeholder-gray-600"
                                                    placeholder="Enter {{ strtolower($field) }}">
                                                @error($fieldName)
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                @if($program->registration_fee > 0)
                                    <div class="bg-red-600/10 border border-red-600/20 p-6 rounded-xl flex items-center justify-between">
                                        <div class="flex items-center text-gray-400 font-medium">
                                            <i class="fas fa-tags mr-3 text-red-500"></i>
                                            Registration Fee
                                        </div>
                                        <div class="text-2xl font-black text-white">
                                            ${{ number_format($program->registration_fee, 2) }}
                                        </div>
                                    </div>
                                @endif

                                <div class="pt-6">
                                    <button type="submit" class="w-full md:w-auto px-12 py-5 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl transition duration-300 shadow-xl shadow-red-600/40 flex items-center justify-center group text-lg">
                                        Submit Registration
                                        <svg class="w-6 h-6 ml-3 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar Ads --}}
            @if(isset($sidebarAds) && $sidebarAds->count())
            <div class="lg:w-80 space-y-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider px-2">Sponsored</h3>
                @foreach($sidebarAds as $ad)
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden group">
                    <div class="relative p-4">
                        <a href="{{ $ad->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ Str::startsWith($ad->image, ['http://', 'https://']) ? $ad->image : asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-auto object-cover transition duration-300 group-hover:opacity-90 rounded-md border border-gray-700">
                        </a>
                        <div class="mt-2 text-center">
                            <p class="text-white text-sm font-medium truncate">{{ $ad->title }}</p>
                            <span class="text-gray-500 text-xs">Advertisement</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.summernote-content p { margin-bottom: 2rem; }
.summernote-content ul { list-style-type: disc; margin-left: 2rem; margin-bottom: 2rem; }
.summernote-content ol { list-style-type: decimal; margin-left: 2rem; margin-bottom: 2rem; }
.animate-bounce-subtle {
    animation: bounce-subtle 3s infinite;
}
@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
</style>
@endsection
