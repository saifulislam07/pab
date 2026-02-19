@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10 flex items-center justify-center">
    <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-lg shadow-2xl overflow-hidden flex flex-col md:flex-row"
             x-data="{ shown: false }" x-intersect="shown = true" 
             :class="{ 'opacity-0 scale-95': !shown, 'opacity-100 scale-100': shown }" class="transition duration-700">
            
            <!-- Information Side -->
            <div class="md:w-1/2 bg-red-900 p-8 text-white flex flex-col justify-center">
                <h2 class="text-3xl font-bold mb-6">{{ $site_setting->login_title ?? 'Welcome Back' }}</h2>
                <p class="mb-6 text-red-100 leading-relaxed">
                    {{ $site_setting->login_description ?? 'Log in to access your dashboard and manage your projects with the Photography Association Bangladesh.' }}
                </p>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $site_setting->login_feature_1 ?? 'Access Your Dashboard' }}</li>
                    <li class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $site_setting->login_feature_2 ?? 'Manage Your Portfolio' }}</li>
                    <li class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $site_setting->login_feature_3 ?? 'Stay Connected' }}</li>
                </ul>
            </div>

            <!-- Form Side -->
            <div class="md:w-1/2 p-8 bg-gray-800">
                <h2 class="text-2xl font-bold text-white mb-6">Log In</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition" required autofocus>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Password</label>
                        <input type="password" name="password" class="w-full bg-gray-700 border-gray-600 rounded text-white focus:ring-red-500 focus:border-red-500 transition" required>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded bg-gray-700 border-gray-600 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                            <span class="ms-2 text-sm text-gray-400">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-red-500 hover:underline">Forgot password?</a>
                        @endif
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white py-3 rounded font-semibold hover:bg-red-700 transition transform hover:scale-105">Log In</button>
                    <p class="text-center text-gray-500 text-sm mt-4">
                        Don't have an account? <a href="{{ route('register') }}" class="text-red-500 hover:underline">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
