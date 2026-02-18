@extends('layouts.frontend')

@section('title', $event->title)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Banner Swiper */
    .banner-swiper {
        width: 100%;
        border-radius: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="bg-gray-900 py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <a href="{{ route('events.index') }}" class="inline-flex items-center text-red-500 hover:text-red-400 mb-8 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to All Events
        </a>

        {{-- Banner Advertisements Carousel --}}
        @if(isset($bannerAds) && $bannerAds->count())
        <div class="mb-12">
            <div class="swiper banner-swiper">
                <div class="swiper-wrapper">
                    @foreach($bannerAds as $ad)
                    <div class="swiper-slide">
                        <div class="relative rounded-xl overflow-hidden shadow-lg border border-gray-700 group bg-gray-800">
                            <a href="{{ $ad->link ?? '#' }}" target="{{ $ad->link ? '_blank' : '_self' }}" rel="noopener noreferrer">
                                <img src="{{ Str::startsWith($ad->image, ['http://', 'https://']) ? $ad->image : asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-auto object-cover transition duration-300 group-hover:opacity-90">
                            </a>
                            <span class="absolute top-2 right-2 bg-black/60 text-gray-400 text-xs px-2 py-1 rounded">Ad</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- Add Pagination if more than 1 ad --}}
                @if($bannerAds->count() > 1)
                    <div class="swiper-pagination"></div>
                @endif
            </div>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Main Content --}}
            <div class="flex-1">
                @if($event->image)
                    <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-auto rounded-xl shadow-2xl mb-12 animate-fade-in shadow-red-900/10 border border-gray-800">
                @endif

                <div class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl">
                    <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-400">
                        <span class="flex items-center bg-gray-900/50 px-3 py-1 rounded-full border border-gray-700">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @if($event->start_date && $event->end_date && $event->start_date != $event->end_date)
                                {{ \Carbon\Carbon::parse($event->start_date)->format('F d') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('F d, Y') }}
                            @elseif($event->start_date)
                                {{ \Carbon\Carbon::parse($event->start_date)->format('F d, Y') }}
                            @else
                                Date TBD
                            @endif
                        </span>
                        @if($event->location)
                        <span class="flex items-center bg-gray-900/50 px-3 py-1 rounded-full border border-gray-700">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </span>
                        @endif
                    </div>

                    <h1 class="text-4xl font-extrabold text-white mb-8 border-b border-gray-700 pb-6">{{ $event->title }}</h1>
                    
                    <div class="prose prose-invert prose-red max-w-none text-gray-300 leading-relaxed summernote-content text-lg">
                        {!! $event->description !!}
                    </div>
                </div>
            </div>

            {{-- Sidebar Advertisements List --}}
            @if(isset($sidebarAds) && $sidebarAds->count())
            <div class="lg:w-80 space-y-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider px-2">Sponsored</h3>
                
                @foreach($sidebarAds as $ad)
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden group">
                    <div class="relative rounded-lg overflow-hidden shadow-inner p-4">
                        <a href="{{ $ad->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ Str::startsWith($ad->image, ['http://', 'https://']) ? $ad->image : asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-auto object-cover transition duration-300 group-hover:opacity-90 rounded-md border border-gray-700">
                        </a>
                        <div class="mt-2">
                            <p class="text-white text-sm font-medium truncate">{{ $ad->title }}</p>
                            <span class="text-gray-500 text-xs">Ad</span>
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
.summernote-content p { margin-bottom: 1.5rem; }
.summernote-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.5rem; }
.summernote-content ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1.5rem; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Banner Swiper in Show Page...');
        // Initialize Banner Swiper (Horizontal Auto-slide)
        const bannerSwiper = new Swiper('.banner-swiper', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            observer: true,
            observeParents: true,
        });
        console.log('Banner Swiper initialized in Show Page:', bannerSwiper);
    });
</script>
@endpush
