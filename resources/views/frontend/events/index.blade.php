@extends('layouts.frontend')

@section('title', 'Recent Events & News')

@section('content')
<div class="bg-gray-900 py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl">Recent Events & News</h2>
            <p class="mt-4 text-xl text-gray-400">Stay updated with our latest activities and announcements.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg group hover:-translate-y-2 transition duration-300">
                    <div class="relative h-56 overflow-hidden">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
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
</div>
@endsection
