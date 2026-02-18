@extends('layouts.frontend')

@section('title', 'Recent Events & News')

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
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl">Recent Events & News</h2>
            <p class="mt-4 text-xl text-gray-400">Stay updated with our latest activities and announcements.</p>
        </div>

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

        {{-- Event Category Tabs --}}
        <div class="flex justify-center mb-10">
            <div class="max-w-full overflow-x-auto pb-2">
                <div class="inline-flex p-1 bg-gray-800 rounded-lg shadow-inner whitespace-nowrap">
                    <a href="{{ route('events.index', ['type' => 'current', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-md transition duration-300 {{ $type === 'current' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                        Current
                    </a>
                    <a href="{{ route('events.index', ['type' => 'upcoming', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-md transition duration-300 {{ $type === 'upcoming' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                        Upcoming
                    </a>
                    <a href="{{ route('events.index', ['type' => 'past', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-md transition duration-300 {{ $type === 'past' ? 'bg-red-600 text-white shadow-lg' : 'text-gray-400 hover:text-white' }}">
                        Past
                    </a>
                </div>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="max-w-2xl mx-auto mb-10">
            <form action="{{ route('events.index') }}" method="GET" class="relative">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search events by title, description, or location..." 
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-full py-3 px-6 pl-12 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent placeholder-gray-500 transition-all duration-300 shadow-md hover:shadow-lg">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit" class="absolute inset-y-0 right-0 pr-1 flex items-center">
                        <span class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2 m-1 transition duration-300 shadow-sm">
                           Search
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Main Events Grid --}}
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($events as $event)
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg group hover:-translate-y-2 transition duration-300">
                            <div class="relative h-56 overflow-hidden">
                                @if($event->image)
                                    <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded text-sm font-semibold">
                                    @if($event->start_date && $event->end_date && $event->start_date != $event->end_date)
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                    @elseif($event->start_date)
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                    @else
                                        Upcoming
                                    @endif
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $event->title }}</h3>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-3">{!! strip_tags($event->description) !!}</p>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-gray-500 text-xs flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $event->location ?? 'Global' }}
                                    </span>
                                    <a href="{{ route('events.show', $event->slug) }}" class="text-red-500 font-semibold hover:text-red-400 text-sm flex items-center">
                                        Read More
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <p class="text-gray-500 italic">No events or news found at this moment.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $events->links() }}
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Banner Swiper...');
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
        console.log('Banner Swiper initialized:', bannerSwiper);
    });
</script>
@endpush
