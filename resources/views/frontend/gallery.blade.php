@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10" 
     x-data="{ 
        modalOpen: false, 
        currentIndex: 0, 
        filter: 'all',
        page: 1,
        loading: false,
        hasMore: {{ $items->hasMorePages() ? 'true' : 'false' }},
        items: {{ Js::from($items->map(function($item) {
            $item->image_url = Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image);
            $item->category_slug = $item->category->slug ?? 'all';
            return $item;
        })) }},
        
        get currentItem() {
            if (!this.items || this.items.length === 0) return { image_url: '', title: '', category_slug: '' };
            return this.items[this.currentIndex] || this.items[0] || { image_url: '', title: '', category_slug: '' };
        },

        async loadMore() {
            console.log('Load More clicked. Current page:', this.page, 'hasMore:', this.hasMore);
            if (this.loading || !this.hasMore) return;
            this.loading = true;
            this.page++;
            await this.fetchItems();
            this.loading = false;
        },

        async changeFilter(newFilter) {
            console.log('Changing filter to:', newFilter);
            if (this.filter === newFilter) return;
            
            this.loading = true;
            this.filter = newFilter;
            this.page = 1;
            // Don't clear items immediately to prevent Alpine x-for spot errors
            // Instead, fetchItems will overwrite them
            await this.fetchItems();
            this.loading = false;
        },

        async fetchItems() {
            try {
                console.log(`Fetching items for page ${this.page}, category: ${this.filter}`);
                // Use a relative URL to avoid CORS/Port issues in local development
                const url = `/gallery-items?page=${this.page}&category=${this.filter}`;
                const response = await fetch(url);
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                console.log('Fetched data:', data);
                
                const newItems = (data.data || []).map(item => {
                    if (item.image) {
                        item.image_url = item.image.startsWith('http') ? item.image : `/storage/${item.image}`;
                    } else {
                        item.image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                    }
                    item.category_slug = item.category ? item.category.slug : 'all';
                    return item;
                });

                if (this.page === 1) {
                    this.items = newItems;
                } else {
                    this.items = [...this.items, ...newItems];
                }
                
                this.hasMore = data.has_more;
                console.log('Current items count:', this.items.length);
            } catch (error) {
                console.error('Error fetching gallery items:', error);
                this.hasMore = false;
            }
        },

        openModal(item) {
            this.currentIndex = this.items.indexOf(item);
            this.modalOpen = true;
        },
        next() {
            if (this.currentIndex < this.items.length - 1) {
                this.currentIndex++;
            } else {
                this.currentIndex = 0;
            }
        },
        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            } else {
                this.currentIndex = this.items.length - 1;
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
            <button @click="changeFilter('all')" 
                    :class="{ 'bg-red-600 text-white': filter === 'all', 'bg-gray-800 text-gray-400 hover:bg-gray-700': filter !== 'all' }"
                    class="px-6 py-2 rounded-full transition duration-300">All ({{ $totalItems }})</button>
            @foreach($categories as $category)
                <button @click="changeFilter('{{ $category->slug }}')" 
                        :class="{ 'bg-red-600 text-white': filter === '{{ $category->slug }}', 'bg-gray-800 text-gray-400 hover:bg-gray-700': filter !== '{{ $category->slug }}' }"
                        class="px-6 py-2 rounded-full transition duration-300 capitalize">
                    {{ $category->name }} ({{ $category->items_count }})
                </button>
            @endforeach
        </div>

        <!-- Masonry Grid -->
        <div class="columns-1 md:columns-3 lg:columns-4 gap-4 space-y-4 min-h-[400px]" x-cloak>
            <template x-for="(item, index) in items" :key="item.id + '-' + filter + '-' + index">
                <div class="break-inside-avoid relative group overflow-hidden rounded-lg cursor-pointer mb-4 animate-fade-in"
                     @click="openModal(item)">
                    <img :src="item.image_url" class="w-full object-cover transition duration-700 group-hover:scale-110" :alt="item.title || 'Gallery Image'">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
            </template>
        </div>

        <!-- Load More Section -->
        <div class="mt-16 text-center" x-show="hasMore">
            <button @click="loadMore()" 
                    :disabled="loading"
                    class="inline-flex items-center px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-red-600/20">
                <span x-show="!loading">Load More Images</span>
                <span x-show="loading" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Loading...
                </span>
            </button>
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
                    <span x-text="currentIndex + 1"></span> of <span x-text="items.length"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
