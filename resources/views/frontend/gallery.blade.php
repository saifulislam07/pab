@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10" 
     x-data="{ 
        modalOpen: false, 
        currentIndex: 0, 
        filter: 'all',
        items: {{ Js::from($items->map(function($item) {
            $item->image_url = Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image);
            $item->category_slug = $item->category->slug ?? 'all';
            return $item;
        })) }},
        get filteredItems() {
            return this.filter === 'all' 
                ? this.items 
                : this.items.filter(i => i.category_slug === this.filter);
        },
        get currentItem() {
            return this.filteredItems[this.currentIndex] || {};
        },
        openModal(item) {
            this.currentIndex = this.filteredItems.indexOf(item);
            this.modalOpen = true;
        },
        next() {
            if (this.currentIndex < this.filteredItems.length - 1) {
                this.currentIndex++;
            } else {
                this.currentIndex = 0;
            }
        },
        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            } else {
                this.currentIndex = this.filteredItems.length - 1;
            }
        }
     }"
     @keydown.escape.window="modalOpen = false"
     @keydown.left.window="if(modalOpen) prev()"
     @keydown.right.window="if(modalOpen) next()">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-white mb-4">Gallery</h1>
            <p class="text-xl text-gray-400">A visual journey through Bangladesh.</p>
            <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
        </div>

        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <button @click="filter = 'all'; currentIndex = 0" 
                    :class="{ 'bg-red-600 text-white': filter === 'all', 'bg-gray-800 text-gray-400 hover:bg-gray-700': filter !== 'all' }"
                    class="px-6 py-2 rounded-full transition duration-300">All</button>
            @foreach($categories as $category)
                <button @click="filter = '{{ $category->slug }}'; currentIndex = 0" 
                        :class="{ 'bg-red-600 text-white': filter === '{{ $category->slug }}', 'bg-gray-800 text-gray-400 hover:bg-gray-700': filter !== '{{ $category->slug }}' }"
                        class="px-6 py-2 rounded-full transition duration-300 capitalize">{{ $category->name }}</button>
            @endforeach
        </div>

        <!-- Masonry Grid -->
        <div class="columns-1 md:columns-3 lg:columns-4 gap-4 space-y-4">
            <template x-for="(item, index) in filteredItems" :key="item.id">
                <div class="break-inside-avoid relative group overflow-hidden rounded-lg cursor-pointer mb-4 animate-fade-in"
                     @click="openModal(item)">
                    <img :src="item.image_url" class="w-full object-cover transition duration-700 group-hover:scale-110" :alt="item.title || 'Gallery Image'">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/95 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <!-- Navigation Buttons -->
        <button @click="prev()" class="absolute left-4 z-70 p-2 text-white hover:text-red-500 transition-colors bg-black/20 hover:bg-black/40 rounded-full">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <button @click="next()" class="absolute right-4 z-70 p-2 text-white hover:text-red-500 transition-colors bg-black/20 hover:bg-black/40 rounded-full">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Close Button -->
        <button @click="modalOpen = false" class="absolute top-4 right-4 z-70 p-2 text-white hover:text-red-500 transition-colors">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Image Container -->
        <div @click.away="modalOpen = false" class="relative max-w-5xl w-full flex flex-col items-center">
            <img :src="currentItem.image_url" class="w-full h-auto max-h-[85vh] object-contain rounded shadow-2xl mb-4">
            
            <div class="text-center">
                <h3 class="text-white text-2xl font-bold" x-text="currentItem.title"></h3>
                <p class="text-gray-400 mt-1 uppercase tracking-widest text-sm" x-text="currentItem.category_slug"></p>
                <div class="text-gray-500 text-sm mt-2">
                    <span x-text="currentIndex + 1"></span> of <span x-text="filteredItems.length"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
