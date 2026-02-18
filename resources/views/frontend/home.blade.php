@extends('layouts.frontend')

@section('content')
    <!-- Hero Slider Section -->
    <div class="relative w-full h-[450px] md:h-[800px] overflow-hidden" x-data="{ 
        activeSlide: 0,
        slides: [
            @foreach($sliders as $slider)
            { 
                img: '{{ Str::startsWith($slider->image, 'http') ? $slider->image : asset('storage/' . $slider->image) }}', 
                title: '{{ $slider->title }}', 
                subtitle: '{{ $slider->subtitle }}' 
            },
            @endforeach
        ],
        next() { this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1 },
        prev() { this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1 },
        init() { setInterval(() => this.next(), 5000) }
    }">
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 :class="{ 'opacity-100': activeSlide === index, 'opacity-0': activeSlide !== index }">
                <img :src="slide.img" class="w-full h-full object-cover" alt="Slider Image">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                    <h1 class="text-3xl md:text-7xl font-bold text-white mb-2 md:mb-6 opacity-0 transform -translate-y-8 transition-all duration-1000 delay-300 leading-tight max-w-5xl"
                        :class="{ 'opacity-100 translate-y-0': activeSlide === index }">
                        <span x-text="slide.title"></span>
                    </h1>
                    <h2 class="text-lg md:text-3xl font-light text-gray-200 tracking-widest uppercase mb-6 md:mb-12 opacity-0 transform translate-y-8 transition-all duration-1000 delay-500 leading-tight"
                        :class="{ 'opacity-100 translate-y-0': activeSlide === index }">
                        <span x-text="slide.subtitle"></span>
                    </h2>
                    <a href="{{ route('registration') }}" 
                       class="px-8 py-3 border-2 border-white text-white font-semibold uppercase tracking-wider hover:bg-white hover:text-black transition duration-300 opacity-0 transform translate-y-10 transition-all duration-1000 delay-700"
                       :class="{ 'opacity-100 translate-y-0': activeSlide === index }">
                        Join Our Community
                    </a>
                </div>
            </div>
        </template>

        <!-- Controls -->
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition p-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition p-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
        
        <!-- Indicators -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === index ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/80'">
                </button>
            </template>
        </div>
    </div>

    <!-- Short About Section -->
    <section class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6" 
                     x-data="{ shown: false }" 
                     x-intersect.once="shown = true"
                     :class="{ 'opacity-0 translate-y-10': !shown, 'opacity-100 translate-y-0': shown }"
                     class="transition-all duration-1000 ease-out">
                    <h3 class="text-red-500 font-semibold tracking-wider uppercase">Who We Are</h3>
                    <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight">
                        {{ $about->title ?? 'Advancing the Art of Photography in Bangladesh' }}
                    </h2>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        {{ Str::limit($about->description ?? 'The Photography Association Bangladesh (PAB) is more than just a club; it\'s a movement. We bring together passionate photographers from all walks of life to share knowledge, inspire creativity, and showcase the stunning visuals of our nation to the world.', 300) }}
                    </p>
                    <div class="grid grid-cols-2 gap-8 py-4">
                        <div>
                            <span class="block text-4xl font-bold text-white mb-2">{{ $about->stats_members ?? '500+' }}</span>
                            <span class="text-sm text-gray-500 uppercase tracking-widest">Active Members</span>
                        </div>
                        <div>
                            <span class="block text-4xl font-bold text-white mb-2">{{ $about->stats_workshops ?? '120+' }}</span>
                            <span class="text-sm text-gray-500 uppercase tracking-widest">Workshops & Events</span>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="inline-block text-red-500 border-b border-red-500 pb-1 hover:text-red-400 hover:border-red-400 transition">
                        Learn More About Us &rarr;
                    </a>
                </div>
                <div class="relative"
                     x-data="{ shown: false }" 
                     x-intersect.once="shown = true"
                     :class="{ 'opacity-0 scale-95': !shown, 'opacity-100 scale-100': shown }"
                     class="transition-all duration-1000 ease-out delay-300">
                    <div class="absolute inset-0 bg-red-500 transform translate-x-4 translate-y-4 rounded-lg"></div>
                    <img src="{{ isset($about->image_main) ? (Str::startsWith($about->image_main, ['http://', 'https://']) ? $about->image_main : asset('storage/' . $about->image_main)) : 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=2000&auto=format&fit=crop' }}" 
                         alt="{{ $about->title ?? 'Who We Are' }}" 
                         class="relative rounded-lg shadow-2xl grayscale hover:grayscale-0 transition duration-500 w-full h-[400px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Works / Gallery Preview -->
    <section class="py-20 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Latest Captures</h2>
            <div class="w-24 h-1 bg-red-500 mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
             @forelse($latest_works as $work)
                <div class="group relative overflow-hidden h-80"
                     x-data="{ shown: false }" 
                     x-intersect.once="shown = true"
                     :class="{ 'opacity-0 translate-y-10': !shown, 'opacity-100 translate-y-0': shown }"
                     class="transition-all duration-700 ease-out">
                    <img src="{{ Str::startsWith($work->image, 'http') ? $work->image : asset('storage/' . $work->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $work->title }}">
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center p-4">
                        <h4 class="text-white text-xl font-bold mb-2 transform translate-y-4 group-hover:translate-y-0 transition duration-300">{{ $work->title }}</h4>
                        <span class="text-xs text-gray-300 uppercase tracking-widest mb-4 transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75">{{ $work->category }}</span>
                        <a href="{{ route('gallery') }}" class="text-white text-sm font-medium tracking-wider border border-white px-6 py-2 hover:bg-white hover:text-black transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-150">View Gallery</a>
                    </div>
                </div>
             @empty
                <div class="col-span-3 text-center text-gray-500 py-12 italic">
                    No gallery items captured yet. Stay tuned!
                </div>
             @endforelse
        </div>
        <div class="text-center mt-12">
             <a href="{{ route('gallery') }}" class="inline-block px-8 py-3 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition">View Full Gallery</a>
        </div>
    </section>
    <!-- Sponsors Section -->
    <section class="py-16 bg-gray-900 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-white uppercase tracking-widest">Our Sponsors & Partners</h2>
                <div class="w-24 h-1 bg-red-600 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 items-center justify-items-center opacity-80 hover:opacity-100 transition duration-500">
                @foreach($sponsors as $sponsor)
                    <a href="{{ $sponsor->link ?? '#' }}" target="_blank" class="grayscale hover:grayscale-0 transition duration-300 transform hover:scale-110">
                        <img src="{{ \Illuminate\Support\Str::startsWith($sponsor->logo, 'http') ? $sponsor->logo : asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" title="{{ $sponsor->name }}" class="h-16 w-auto object-contain">
                    </a>
                @endforeach
            </div>
            
            @if($sponsors->isEmpty())
                <div class="flex flex-wrap justify-center gap-12 opacity-30 grayscale items-center">
                    <img src="https://via.placeholder.com/150x50?text=Sponsor+1" alt="Sponsor" class="h-12 w-auto">
                    <img src="https://via.placeholder.com/150x50?text=Sponsor+2" alt="Sponsor" class="h-12 w-auto">
                    <img src="https://via.placeholder.com/150x50?text=Sponsor+3" alt="Sponsor" class="h-12 w-auto">
                    <img src="https://via.placeholder.com/150x50?text=Sponsor+4" alt="Sponsor" class="h-12 w-auto">
                </div>
            @endif
        </div>
    </section>
@endsection
