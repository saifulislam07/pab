@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">Our Members</h1>
            <p class="text-gray-400">The creative souls behind the lens.</p>
        </div>

        <!-- Filter/Search -->
        <div class="mb-10 flex justify-center" x-data>
            <input type="text" x-model="$store.search.query" placeholder="Search members..." class="bg-gray-800 border-gray-700 text-white rounded-full px-6 py-2 w-full max-w-md focus:ring-red-500 focus:border-red-500 transition">
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" 
             x-data="{ members: {{ Js::from($members) }} }">
            <template x-for="member in members.filter(m => m.name.toLowerCase().includes($store.search.query.toLowerCase()) || m.role.toLowerCase().includes($store.search.query.toLowerCase()))" :key="member.id">
                <div class="bg-gray-800 rounded-lg p-6 text-center hover:bg-gray-750 transition"
                     x-data="{ shown: false }" x-intersect="shown = true" 
                     :class="{ 'opacity-0 scale-90': !shown, 'opacity-100 scale-100': shown }" class="transition duration-500">
                    <div class="w-24 h-24 mx-auto bg-gray-700 rounded-full mb-4 overflow-hidden">
                        <img :src="member.image" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-semibold text-white" x-text="member.name"></h3>
                    <p class="text-sm text-gray-500" x-text="member.role"></p>
                </div>
            </template>
            
            <div x-show="members.filter(m => m.name.toLowerCase().includes($store.search.query.toLowerCase())).length === 0" class="col-span-full text-center text-gray-500 py-10">
                No members found matching your search.
            </div>
        </div>
        
        <div class="mt-12 text-center">
             <button class="px-6 py-2 border border-gray-600 text-gray-400 hover:text-white hover:border-white rounded transition">Load More</button>
        </div>
    </div>
</div>
@endsection
