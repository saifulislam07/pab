@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16" 
         x-data="{ shown: false }" x-intersect="shown = true" 
         :class="{ 'opacity-0 translate-y-10': !shown, 'opacity-100 translate-y-0': shown }" class="transition duration-1000">
        <h1 class="text-5xl font-bold text-white mb-4">About Us</h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">Discover the passion, history, and vision behind the Photography Association Bangladesh.</p>
        <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <!-- Image Grid -->
        <div class="grid grid-cols-2 gap-4"
             x-data="{ shown: false }" x-intersect="shown = true" 
             :class="{ 'opacity-0 scale-95': !shown, 'opacity-100 scale-100': shown }" class="transition duration-1000 delay-200">
            <img src="https://images.unsplash.com/photo-1552168324-d612d77725e3?q=80&w=600&auto=format&fit=crop" class="rounded-lg shadow-xl transform translate-y-8">
            <img src="https://images.unsplash.com/photo-1542038784456-1ea8c9356efb?q=80&w=600&auto=format&fit=crop" class="rounded-lg shadow-xl">
        </div>

        <!-- Text Content -->
        <div class="space-y-6"
             x-data="{ shown: false }" x-intersect="shown = true" 
             :class="{ 'opacity-0 translate-x-10': !shown, 'opacity-100 translate-x-0': shown }" class="transition duration-1000 delay-400">
            <h2 class="text-3xl font-bold text-white">Our Story</h2>
            <p class="text-gray-300 leading-relaxed">
                Founded in 2010, the Photography Association Bangladesh (PAB) started as a small gathering of enthusiasts in Dhaka. Over the years, it has blossomed into a nationwide community dedicated to the art and craft of photography.
            </p>
            <p class="text-gray-300 leading-relaxed">
                We believe that every picture tells a story. Our mission is to provide a platform for photographers to learn, share, and grow. From workshops and photo walks to grand exhibitions, we curate events that inspire creativity and foster meaningful connections.
            </p>
            <div class="pt-4">
                <a href="{{ route('contact') }}" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded transition">Get in Touch</a>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-gray-800 mt-20 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach([
                ['count' => '15+', 'label' => 'Years Active'],
                ['count' => '500+', 'label' => 'Members'],
                ['count' => '120+', 'label' => 'Workshops'],
                ['count' => '50+', 'label' => 'Awards Won']
            ] as $stat)
                <div x-data="{ shown: false }" x-intersect="shown = true" 
                     :class="{ 'opacity-0 translate-y-4': !shown, 'opacity-100 translate-y-0': shown }" class="transition duration-700">
                    <span class="block text-4xl font-bold text-red-500 mb-2">{{ $stat['count'] }}</span>
                    <span class="text-sm text-gray-400 uppercase tracking-widest">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
