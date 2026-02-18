@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-white mb-4">Contact Us</h1>
            <p class="text-xl text-gray-400">We'd love to hear from you.</p>
            <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div class="bg-gray-800 p-8 rounded-lg shadow-lg"
                     x-data="{ shown: false }" x-intersect="shown = true" 
                     :class="{ 'opacity-0 -translate-x-10': !shown, 'opacity-100 translate-x-0': shown }" class="transition duration-700">
                    <h3 class="text-2xl font-bold text-white mb-6">Get In Touch</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center p-3 bg-red-900 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-red-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-white">Phone</h4>
                                <p class="mt-1 text-gray-400">{{ $site_setting->contact_phone ?? '+880 1234 567890' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                             <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center p-3 bg-red-900 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-red-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-white">Email</h4>
                                <p class="mt-1 text-gray-400">{{ $site_setting->contact_email ?? 'info@pab.bt' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                             <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center p-3 bg-red-900 rounded-md shadow-lg">
                                    <svg class="h-6 w-6 text-red-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-white">Address</h4>
                                <p class="mt-1 text-gray-400">{{ $site_setting->address ?? 'House 123, Road 45, Dhanmondi, Dhaka-1209' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg"
                 x-data="{ shown: false }" x-intersect="shown = true" 
                 :class="{ 'opacity-0 translate-x-10': !shown, 'opacity-100 translate-x-0': shown }" class="transition duration-700 delay-200">
                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">First Name</label>
                            <input type="text" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Last Name</label>
                            <input type="text" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Email</label>
                        <input type="email" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Message</label>
                        <textarea rows="4" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white py-3 rounded font-semibold hover:bg-red-700 transition transform hover:scale-105">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
