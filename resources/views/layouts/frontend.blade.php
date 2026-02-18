<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $site_setting->site_title ?? config('app.name', 'Photography Association Bangladesh') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .glass-nav {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s ease-out forwards;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-900 text-gray-100 selection:bg-red-500 selection:text-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav x-data="{ open: false, scrolled: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 20)"
             :class="{ 'glass-nav shadow-lg': scrolled, 'bg-transparent': !scrolled }"
             class="fixed w-full z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}">
                                @if(isset($site_setting->logo))
                                    <img src="{{ asset('storage/' . $site_setting->logo) }}" alt="{{ $site_setting->site_name }}" class="h-16 w-auto">
                                @else
                                    <img src="{{ asset('images/logo.svg') }}" alt="PAB Logo" class="h-16 w-auto">
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
                        @foreach([
                            'Home' => 'home',
                            'About' => 'about',
                            'Mission & Vision' => 'mission-vision',
                            'Team' => 'team',
                            'Members' => 'members',
                            'Events' => 'events.index',
                            'Registration' => 'registration',
                            'Gallery' => 'gallery',
                            'Contact' => 'contact'
                        ] as $label => $route)
                            <a href="{{ route($route) }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                                      {{ Route::currentRouteName() == $route 
                                         ? 'border-red-500 text-white' 
                                         : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                        
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-red-500 hover:text-red-400 transition ml-4">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition ml-4">Log in</a>
                        @endauth
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-900 border-b border-gray-800">
                <div class="pt-2 pb-3 space-y-1">
                    @foreach([
                        'Home' => 'home',
                        'About' => 'about',
                        'Mission & Vision' => 'mission-vision',
                        'Team' => 'team',
                        'Members' => 'members',
                        'Registration' => 'registration',
                        'Gallery' => 'gallery',
                        'Contact' => 'contact'
                    ] as $label => $route)
                        <a href="{{ route($route) }}" 
                           class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out
                                  {{ Route::currentRouteName() == $route 
                                     ? 'border-red-500 text-white bg-gray-800' 
                                     : 'border-transparent text-gray-400 hover:text-white hover:bg-gray-800 hover:border-gray-300' }}">
                            {{ $label }}
                        </a>
                    @endforeach

                    <!-- Mobile Auth Links -->
                    <div class="pt-4 pb-1 border-t border-gray-800">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-red-500 hover:text-red-400 hover:bg-gray-800 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow pt-20">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 border-t border-gray-800 text-gray-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    @if(isset($site_setting->logo))
                        <img src="{{ asset('storage/' . $site_setting->logo) }}" alt="{{ $site_setting->site_name }}" class="h-16 w-auto mb-4">
                    @else
                        <img src="{{ asset('images/logo.svg') }}" alt="PAB Logo" class="h-16 w-auto mb-4">
                    @endif
                    <p class="text-sm leading-relaxed mb-4">
                        {{ $site_setting->footer_text ?? 'Uniting photographers, inspiring creativity, and capturing the essence of Bangladesh. Join our community to explore the art of visual storytelling.' }}
                    </p>
                    <div class="flex space-x-4">
                        @if($site_setting->facebook_link) 
                            <a href="{{ $site_setting->facebook_link }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-red-600 hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a> 
                        @endif
                        @if($site_setting->instagram_link) 
                            <a href="{{ $site_setting->instagram_link }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-red-600 hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a> 
                        @endif
                        @if($site_setting->twitter_link) 
                            <a href="{{ $site_setting->twitter_link }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-red-600 hover:text-white transition">
                                <i class="fab fa-twitter"></i>
                            </a> 
                        @endif
                        @if($site_setting->linkedin_link) 
                            <a href="{{ $site_setting->linkedin_link }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 text-gray-400 hover:bg-red-600 hover:text-white transition">
                                <i class="fab fa-linkedin-in"></i>
                            </a> 
                        @endif
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-red-500 transition">About Us</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-red-500 transition">Gallery</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-red-500 transition">Contact</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-red-500 transition">Member Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li>{{ $site_setting->address ?? 'Dhaka, Bangladesh' }}</li>
                        <li>{{ $site_setting->contact_email ?? 'info@pab.bt' }}</li>
                        <li>{{ $site_setting->contact_phone ?? '+880 1234 567890' }}</li>
                    </ul>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-xs">
                &copy; {{ date('Y') }} {{ $site_setting->site_name ?? 'Photography Association Bangladesh' }}. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
