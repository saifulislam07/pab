@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="text-center mb-12 md:20 animate-fade-in">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $content->title ?? 'Mission & Vision' }}</h1>
            <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto px-4">{{ $content->subtitle ?? 'Guiding the future of photography in Bangladesh with purpose and passion.' }}</p>
            <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
        </div>

        <!-- Mission Section -->
        <section class="mb-16 md:mb-24 animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="relative px-4 md:px-0">
                    <div class="absolute inset-0 bg-red-500 transform translate-x-2 translate-y-2 md:translate-x-4 md:translate-y-4 rounded-lg"></div>
                    <img src="{{ Str::startsWith($content->mission_image ?? '', 'http') ? $content->mission_image : asset('storage/' . $content->mission_image) }}"
                         alt="{{ $content->mission_title ?? 'Our Mission' }}"
                         class="relative rounded-lg shadow-2xl w-full h-64 md:h-80 object-cover grayscale hover:grayscale-0 transition duration-500">
                </div>
                <div class="space-y-6 px-4 md:px-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-4xl font-bold text-white">{{ $content->mission_title ?? 'Our Mission' }}</h2>
                    </div>
                    <p class="text-gray-400 text-base md:text-lg leading-relaxed">
                        {{ $content->mission_description ?? '' }}
                    </p>
                    <ul class="space-y-3">
                        @foreach($content->mission_points ?? [] as $point)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300 text-sm md:text-base">{{ $point }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <!-- Vision Section -->
        <section class="mb-16 md:mb-24 animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="space-y-6 order-2 lg:order-1 px-4 md:px-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-4xl font-bold text-white">{{ $content->vision_title ?? 'Our Vision' }}</h2>
                    </div>
                    <p class="text-gray-400 text-base md:text-lg leading-relaxed">
                        {{ $content->vision_description ?? '' }}
                    </p>
                    <ul class="space-y-3">
                        @foreach($content->vision_points ?? [] as $point)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-1 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-gray-300 text-sm md:text-base">{{ $point }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="relative order-1 lg:order-2 px-4 md:px-0">
                    <div class="absolute inset-0 bg-red-500 transform -translate-x-2 translate-y-2 md:-translate-x-4 md:translate-y-4 rounded-lg"></div>
                    <img src="{{ Str::startsWith($content->vision_image ?? '', 'http') ? $content->vision_image : asset('storage/' . $content->vision_image) }}"
                         alt="{{ $content->vision_title ?? 'Our Vision' }}"
                         class="relative rounded-lg shadow-2xl w-full h-64 md:h-80 object-cover grayscale hover:grayscale-0 transition duration-500">
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section class="animate-fade-in mb-12">
            <div class="text-center mb-10 md:mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Our Core Values</h2>
                <div class="w-24 h-1 bg-red-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4 md:px-0">
                @foreach($content->core_values ?? [] as $value)
                    <div class="bg-gray-800 rounded-lg p-6 md:p-8 text-center hover:bg-gray-750 hover:-translate-y-1 transition duration-300 group">
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-red-600/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-red-600/40 transition">
                            <svg class="w-7 h-7 md:w-8 md:h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-white mb-3">{{ $value['title'] }}</h3>
                        <p class="text-gray-400 text-xs md:text-sm leading-relaxed">{{ $value['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</div>
@endsection
