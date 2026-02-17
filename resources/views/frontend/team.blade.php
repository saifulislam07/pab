@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-fade-in">
            <h1 class="text-5xl font-bold text-white mb-4">Our Team</h1>
            <p class="text-xl text-gray-400">Meet the visionaries leading our community.</p>
            <div class="w-24 h-1 bg-red-500 mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Rahim Ahmed', 'role' => 'President', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d'],
                ['name' => 'Fatima Begum', 'role' => 'Vice President', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330'],
                ['name' => 'Kamal Hossain', 'role' => 'Secretary', 'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e'],
                ['name' => 'Nasima Akter', 'role' => 'Treasurer', 'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80'],
                ['name' => 'Tanvir Rahman', 'role' => 'Creative Director', 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e'],
                ['name' => 'Sadia Islam', 'role' => 'Event Coordinator', 'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb'],
                ['name' => 'Arif Hasan', 'role' => 'Workshop Lead', 'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d'],
                ['name' => 'Mithila Chowdhury', 'role' => 'Media Manager', 'img' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04'],
                ['name' => 'Jubayer Khan', 'role' => 'Technical Advisor', 'img' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef'],
                ['name' => 'Ruma Sultana', 'role' => 'Membership Coordinator', 'img' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2']
            ] as $member)
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg group hover:-translate-y-2 transition duration-300 animate-fade-in">
                    <div class="relative h-80 overflow-hidden">
                        <img src="{{ $member['img'] }}?q=80&w=400&auto=format&fit=crop" alt="{{ $member['name'] }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-4">
                            <div class="flex space-x-4">
                                <a href="#" class="text-white hover:text-red-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                                <a href="#" class="text-white hover:text-red-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-white">{{ $member['name'] }}</h3>
                        <p class="text-red-500 text-sm uppercase tracking-wide mt-1">{{ $member['role'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
