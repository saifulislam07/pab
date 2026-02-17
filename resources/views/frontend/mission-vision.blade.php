@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="text-center mb-20 animate-fade-in">
            <h1 class="text-5xl font-bold text-white mb-4">Mission & Vision</h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">Guiding the future of photography in Bangladesh with purpose and passion.</p>
            <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
        </div>

        <!-- Mission Section -->
        <section class="mb-24 animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-red-500 transform translate-x-4 translate-y-4 rounded-lg"></div>
                    <img src="https://images.unsplash.com/photo-1452587925148-ce544e77e70d?q=80&w=800&auto=format&fit=crop"
                         alt="Our Mission"
                         class="relative rounded-lg shadow-2xl w-full h-80 object-cover grayscale hover:grayscale-0 transition duration-500">
                </div>
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white">Our Mission</h2>
                    </div>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        To foster a vibrant and inclusive community of photographers across Bangladesh, providing platforms for learning, collaboration, and exhibition. We are dedicated to nurturing emerging talent, preserving the country's visual heritage, and empowering photographers to tell stories that inspire change.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300">Promote photographic education through workshops and mentorship programs</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300">Create opportunities for exhibition, awards, and professional growth</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300">Build bridges between local and international photography communities</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Vision Section -->
        <section class="mb-24 animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 order-2 lg:order-1">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white">Our Vision</h2>
                    </div>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        To become the leading photography association in South Asia — a beacon for creativity, cultural storytelling, and artistic excellence. We envision a Bangladesh where every story is captured, every moment is valued, and photography is recognized as a powerful medium for social impact and cultural preservation.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300">Establish PAB as a globally recognized photography community</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300">Use photography as a tool for social awareness and positive change</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300">Preserve Bangladesh's rich visual and cultural heritage for future generations</span>
                        </li>
                    </ul>
                </div>
                <div class="relative order-1 lg:order-2">
                    <div class="absolute inset-0 bg-red-500 transform -translate-x-4 translate-y-4 rounded-lg"></div>
                    <img src="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=800&auto=format&fit=crop"
                         alt="Our Vision"
                         class="relative rounded-lg shadow-2xl w-full h-80 object-cover grayscale hover:grayscale-0 transition duration-500">
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section class="animate-fade-in">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Our Core Values</h2>
                <div class="w-24 h-1 bg-red-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Education', 'desc' => 'Continuous learning and knowledge sharing through workshops and mentorship.'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Community', 'desc' => 'Building lasting bonds among photographers of all backgrounds and skill levels.'],
                    ['icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'title' => 'Creativity', 'desc' => 'Encouraging artistic expression and pushing the boundaries of visual storytelling.'],
                    ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Impact', 'desc' => 'Using the power of imagery to drive meaningful social and cultural change.']
                ] as $value)
                    <div class="bg-gray-800 rounded-lg p-8 text-center hover:bg-gray-750 hover:-translate-y-1 transition duration-300 group">
                        <div class="w-16 h-16 bg-red-600/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-red-600/40 transition">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $value['title'] }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">{{ $value['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</div>
@endsection
