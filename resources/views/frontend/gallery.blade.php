@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10" x-data="{ modalOpen: false, modalImage: '', filter: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-white mb-4">Gallery</h1>
            <p class="text-xl text-gray-400">A visual journey through Bangladesh.</p>
            <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
        </div>

        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <button @click="filter = 'all'" 
                    :class="{ 'bg-red-600 text-white': filter === 'all', 'bg-gray-800 text-gray-400 hover:bg-gray-700': filter !== 'all' }"
                    class="px-6 py-2 rounded-full transition duration-300">All</button>
            @foreach($categories as $category)
                <button @click="filter = '{{ $category }}'" 
                        :class="{ 'bg-red-600 text-white': filter === '{{ $category }}', 'bg-gray-800 text-gray-400 hover:bg-gray-700': filter !== '{{ $category }}' }"
                        class="px-6 py-2 rounded-full transition duration-300 capitalize">{{ $category }}</button>
            @endforeach
        </div>

        <!-- Masonry Grid -->
        <div class="columns-1 md:columns-3 lg:columns-4 gap-4 space-y-4" x-data="{ items: {{ Js::from($items) }} }">
            <template x-for="item in items.filter(i => filter === 'all' || i.category === filter)" :key="item.id">
                <div class="break-inside-avoid relative group overflow-hidden rounded-lg cursor-pointer mb-4 animate-fade-in"
                     @click="modalOpen = true; modalImage = item.image + '?q=80&w=1200&auto=format&fit=crop'">
                    <img :src="item.image + '?q=80&w=600&auto=format&fit=crop'" class="w-full object-cover transition duration-700 group-hover:scale-110" :alt="item.title || 'Gallery Image'">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div @click.away="modalOpen = false" class="relative max-w-5xl w-full max-h-screen">
            <button @click="modalOpen = false" class="absolute -top-10 right-0 text-white hover:text-red-500 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img :src="modalImage" class="w-full h-auto max-h-[90vh] object-contain rounded shadow-2xl">
        </div>
    </div>
</div>
@endsection
