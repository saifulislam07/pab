@extends('layouts.frontend')

@section('title', 'Programs & Events')

@section('content')
<div class="bg-gray-900 py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl">Programs & Registrations</h2>
            <p class="mt-4 text-xl text-gray-400">Participate in our upcoming programs and activities.</p>
        </div>

        {{-- Search Bar --}}
        <div class="max-w-2xl mx-auto mb-10">
            <form action="{{ route('programs.index') }}" method="GET" class="relative">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search programs..." 
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
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($programs as $program)
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg group hover:-translate-y-2 transition duration-300 border border-gray-700">
                            <div class="relative h-56 overflow-hidden">
                                @if($program->image)
                                    <img src="{{ Str::startsWith($program->image, ['http://', 'https://']) ? $program->image : asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif
                                @if($program->is_registration_active)
                                    <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                                        Registration Open
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $program->title }}</h3>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-3">{!! strip_tags($program->description) !!}</p>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-gray-500 text-xs flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('M d, Y') : 'Date TBD' }}
                                    </span>
                                    <a href="{{ route('programs.show', $program->slug) }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition duration-300">
                                        Details
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-gray-800 rounded-xl border border-dashed border-gray-700">
                            <p class="text-gray-500 italic text-lg">No active programs found at this moment.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $programs->links() }}
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
                        <div class="mt-2">
                            <p class="text-white text-sm font-medium truncate">{{ $ad->title }}</p>
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
