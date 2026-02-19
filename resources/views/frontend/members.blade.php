@extends('layouts.frontend')

@section('content')
<div class="bg-gray-900 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-5xl font-bold text-white mb-4">Our Members</h1>
            <p class="text-gray-400">The creative souls behind the lens.</p>
        </div>

        <div x-data="{
                allMembers: {{ Js::from($members) }},
                visibleCount: 8,
                query: '',
                selectedDivision: '',
                selectedDistrict: '',

                get divisions() {
                    return [...new Set(this.allMembers.map(m => m.division).filter(Boolean))].sort();
                },

                get districts() {
                    let pool = this.allMembers;
                    if (this.selectedDivision) {
                        pool = pool.filter(m => m.division === this.selectedDivision);
                    }
                    return [...new Set(pool.map(m => m.district).filter(Boolean))].sort();
                },

                get filtered() {
                    const q = this.query.toLowerCase().trim();
                    
                    return this.allMembers.filter(m => {
                        // Text search match
                        const textMatch = !q || (
                            (m.name || '').toLowerCase().includes(q) ||
                            (m.role || '').toLowerCase().includes(q) ||
                            (m.title || '').toLowerCase().includes(q) ||
                            (m.member_id || '').toLowerCase().includes(q) ||
                            (m.permission && ((m.email || '').toLowerCase().includes(q) || (m.mobile || '').toLowerCase().includes(q)))
                        );

                        // Location matches
                        const divisionMatch = !this.selectedDivision || m.division === this.selectedDivision;
                        const districtMatch = !this.selectedDistrict || m.district === this.selectedDistrict;

                        return textMatch && divisionMatch && districtMatch;
                    });
                },
                get visible() {
                    return this.filtered.slice(0, this.visibleCount);
                },
                get hasMore() {
                    return this.visibleCount < this.filtered.length;
                },
                loadMore() {
                    this.visibleCount += 8;
                },
                resetFilters() {
                    this.query = '';
                    this.selectedDivision = '';
                    this.selectedDistrict = '';
                }
            }">

            <!-- Filter/Search -->
            <div class="mb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">
                    <!-- Text Search -->
                    <div class="relative">
                        <input type="text" x-model="query" placeholder="Name, ID, Contact..." 
                               class="bg-gray-800 border border-gray-700 text-white rounded-lg pl-11 pr-4 py-2.5 w-full focus:ring-2 focus:ring-red-500 focus:border-transparent transition outline-none shadow-sm">
                     
                    </div>

                    <!-- Division Filter -->
                    <select x-model="selectedDivision" @change="selectedDistrict = ''" 
                            class="bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5 w-full focus:ring-2 focus:ring-red-500 focus:border-transparent transition outline-none cursor-pointer">
                        <option value="">All Divisions</option>
                        <template x-for="div in divisions" :key="div">
                            <option :value="div" x-text="div"></option>
                        </template>
                    </select>

                    <!-- District Filter -->
                    <select x-model="selectedDistrict" 
                            class="bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5 w-full focus:ring-2 focus:ring-red-500 focus:border-transparent transition outline-none cursor-pointer">
                        <option value="">All Districts</option>
                        <template x-for="dist in districts" :key="dist">
                            <option :value="dist" x-text="dist"></option>
                        </template>
                    </select>
                </div>
                
                <div class="mt-4 text-center" x-show="query || selectedDivision || selectedDistrict">
                    <button @click="resetFilters()" class="text-sm text-gray-500 hover:text-red-500 transition">
                        <i class="fas fa-times-circle mr-1"></i> Clear all filters
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <template x-for="member in visible" :key="member.id">
                    <a :href="'{{ route('members.show', ':id') }}'.replace(':id', member.id)" class="bg-gray-800 rounded-lg p-6 text-center hover:bg-gray-700 transition animate-fade-in group border border-transparent hover:border-red-500 cursor-pointer block">
                        <div class="w-24 h-24 mx-auto bg-gray-700 rounded-full mb-4 overflow-hidden ring-2 ring-gray-600 group-hover:ring-red-500 transition relative">
                            <img :src="member.image ? (member.image.startsWith('http') ? member.image : '{{ asset('storage') }}/' + member.image) : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(member.name)" class="w-full h-full object-cover" :alt="member.name">
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-white flex items-center justify-center flex-wrap">
                            <span x-text="member.name"></span>
                            <span class="relative inline-flex items-center justify-center ml-1.5" x-show="member.membership_status === 'active'">
                                <i class="fas fa-certificate text-base sm:text-lg animate-pulse-slow" 
                                   :class="member.membership_type === 'lifetime' ? 'text-blue-900 glow-lifetime' : 'text-blue-400 glow-yearly'"
                                   :title="member.membership_type === 'lifetime' ? 'Lifetime Verified' : 'Yearly Verified'"></i>
                                <i class="fas fa-check text-white absolute" style="font-size: 0.35rem;"></i>
                            </span>
                        </h3>
                        <p class="text-xs text-red-500 font-bold uppercase tracking-wider mb-1" x-text="member.title || 'Photographer'"></p>
                        <p class="text-xs text-gray-500" x-text="(member.district ? member.district + ', ' : '') + (member.division || '')"></p>
                        
                        <div class="mt-4 pt-3 border-t border-gray-700">
                            <span class="text-xs font-bold text-red-500 uppercase tracking-widest group-hover:text-white transition">View Profile <i class="fas fa-chevron-right ml-1"></i></span>
                        </div>
                    </a>
                </template>

                <div x-show="filtered.length === 0" class="col-span-full text-center text-gray-500 py-10">
                    No members found matching your search.
                </div>
            </div>

            <div class="mt-12 text-center" x-show="hasMore" x-transition>
                <button @click="loadMore()" class="px-8 py-3 border border-gray-600 text-gray-400 hover:text-white hover:border-white rounded-full transition duration-300">
                    Load More
                    <span class="text-sm ml-1" x-text="'(' + visible.length + ' of ' + filtered.length + ')'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
