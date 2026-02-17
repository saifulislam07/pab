@extends('layouts.frontend')

@section('content')
    <!-- Hero Slider Section -->
    <div class="relative w-full h-[600px] md:h-[800px] overflow-hidden" x-data="{ 
        activeSlide: 0,
        slides: [
            { img: 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?q=80&w=2574&auto=format&fit=crop', title: 'Capturing Moments', subtitle: 'The Art of Visual Storytelling' },
            { img: 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2670&auto=format&fit=crop', title: 'Explore Nature', subtitle: 'Beauty of Bangladesh' },
            { img: 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=2670&auto=format&fit=crop', title: 'Urban Life', subtitle: 'Stories from the Streets' }
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
                    <h2 class="text-xl md:text-3xl font-light text-gray-200 tracking-widest uppercase mb-4 opacity-0 transform translate-y-10 transition-all duration-1000 delay-300"
                        :class="{ 'opacity-100 translate-y-0': activeSlide === index }">
                        <span x-text="slide.subtitle"></span>
                    </h2>
                    <h1 class="text-4xl md:text-7xl font-bold text-white mb-8 opacity-0 transform scale-90 transition-all duration-1000 delay-500"
                        :class="{ 'opacity-100 scale-100': activeSlide === index }">
                        <span x-text="slide.title"></span>
                    </h1>
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
                        Advancing the Art of Photography in Bangladesh
                    </h2>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        The Photography Association Bangladesh (PAB) is more than just a club; it's a movement. We bring together passionate photographers from all walks of life to share knowledge, inspire creativity, and showcase the stunning visuals of our nation to the world.
                    </p>
                    <div class="grid grid-cols-2 gap-8 py-4">
                        <div>
                            <span class="block text-4xl font-bold text-white mb-2">500+</span>
                            <span class="text-sm text-gray-500 uppercase tracking-widest">Active Members</span>
                        </div>
                        <div>
                            <span class="block text-4xl font-bold text-white mb-2">120+</span>
                            <span class="text-sm text-gray-500 uppercase tracking-widest">Exhibitions</span>
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
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=2000&auto=format&fit=crop" 
                         alt="Photographer at work" 
                         class="relative rounded-lg shadow-2xl grayscale hover:grayscale-0 transition duration-500">
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
             @foreach(['https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05', 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d', 'https://images.unsplash.com/photo-1433086966358-54859d0ed716'] as $img)
                <div class="group relative overflow-hidden h-80"
                     x-data="{ shown: false }" 
                     x-intersect.once="shown = true"
                     :class="{ 'opacity-0 translate-y-10': !shown, 'opacity-100 translate-y-0': shown }"
                     class="transition-all duration-700 ease-out">
                    <img src="{{ $img }}?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="Gallery Image">
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <span class="text-white text-lg font-medium tracking-wider border border-white px-6 py-2">View Project</span>
                    </div>
                </div>
             @endforeach
        </div>
        <div class="text-center mt-12">
             <a href="{{ route('gallery') }}" class="inline-block px-8 py-3 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition">View Full Gallery</a>
        </div>
    </section>
@endsection
