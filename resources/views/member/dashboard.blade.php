<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="mb-6">You are now logged in as a registered member of PAB. Here you will find your exclusive resources and community updates.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-bold text-red-500 mb-2">Member Profile</h4>
                            <p class="text-sm">Keep your professional information up to date.</p>
                            <a href="{{ route('profile.edit') }}" class="mt-4 inline-block text-sm font-semibold text-gray-900 dark:text-white hover:underline">Edit Profile →</a>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-bold text-red-500 mb-2">Upcoming Events</h4>
                            <p class="text-sm">Browse our latest workshops and community meetups.</p>
                            <a href="{{ route('events.index') }}" class="mt-4 inline-block text-sm font-semibold text-gray-900 dark:text-white hover:underline">View Events →</a>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-bold text-red-500 mb-2">PAB Gallery</h4>
                            <p class="text-sm">See archives of our past activities and achievements.</p>
                            <a href="{{ route('gallery') }}" class="mt-4 inline-block text-sm font-semibold text-gray-900 dark:text-white hover:underline">Open Gallery →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
