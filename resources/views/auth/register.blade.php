@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10 flex items-center justify-center">
    <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-lg shadow-2xl overflow-hidden flex flex-col md:flex-row"
             x-data="{ shown: false }" x-intersect="shown = true" 
             :class="{ 'opacity-0 scale-95': !shown, 'opacity-100 scale-100': shown }" class="transition duration-700">
            
            <!-- Information Side -->
            <div class="md:w-1/2 bg-red-900 p-8 text-white flex flex-col justify-center">
                <h2 class="text-3xl font-bold mb-6">{{ $site_setting->register_title ?? 'Join Us' }}</h2>
                <p class="mb-6 text-red-100 leading-relaxed">
                    {{ $site_setting->register_description ?? 'Create an account to join the Photography Association Bangladesh and start showcasing your work to the world.' }}
                </p>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $site_setting->register_feature_1 ?? 'Showcase Your Talent' }}</li>
                    <li class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $site_setting->register_feature_2 ?? 'Connect with Professionals' }}</li>
                    <li class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $site_setting->register_feature_3 ?? 'Expand Your Horizons' }}</li>
                </ul>
            </div>

            <!-- Form Side -->
            <div class="md:w-1/2 p-8 bg-gray-800">
                <h2 class="text-2xl font-bold text-white mb-6">Create Account</h2>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Password</label>
                        <input type="password" name="password" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-red-600 text-white py-3 rounded font-semibold hover:bg-red-700 transition transform hover:scale-105">Register</button>

                    <p class="text-center text-gray-500 text-sm mt-4">
                        Already have an account? <a href="{{ route('login') }}" class="text-red-500 hover:underline">Log in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
