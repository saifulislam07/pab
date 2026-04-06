@extends('layouts.frontend')

@section('title', $program->title)

@section('content')
    <div class="bg-gray-900 py-10 md:py-20 px-4 md:px-6">
        <div class="max-w-6xl mx-auto">
            <a href="{{ route('programs.index') }}" class="inline-flex items-center text-red-500 hover:text-red-400 mb-8 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to All Programs
            </a>

            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Main Content --}}
                <div class="flex-1">
                    @if($program->image)
                        <img src="{{ Str::startsWith($program->image, ['http://', 'https://']) ? $program->image : asset('programe/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-auto rounded-xl shadow-2xl mb-12 animate-fade-in shadow-red-900/10 border border-gray-800">
                    @endif

                    <div class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl overflow-hidden relative">
                        <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-400">
                            <span class="flex items-center bg-gray-900/50 px-3 py-1 rounded-full border border-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($program->start_date)->format('F d, Y') }}
                            </span>
                            @if($program->location)
                            <span class="flex items-center bg-gray-900/50 px-3 py-1 rounded-full border border-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $program->location }}
                            </span>
                            @endif
                        </div>

                        @if($program->sponsors->count() > 0)
                            <div class="mb-8 p-1 rounded-xl bg-gradient-to-r from-red-600/30 via-red-500/10 to-red-600/30">
                                <div class="bg-gray-900 rounded-lg p-6">
                                    <div class="flex items-center justify-center sm:justify-start mb-6">
                                        <h3 class="text-xl font-black text-white flex items-center tracking-widest uppercase">
                                            <i class="fas fa-handshake text-red-500 mr-3 text-2xl"></i>
                                            Proud Sponsors
                                        </h3>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($program->sponsors as $sponsor)
                                            <div class="group relative bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-red-500/50 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-[0_10px_20px_rgba(220,38,38,0.2)] flex flex-col items-center text-center">
                                                <!-- Subtle glow behind sponsor -->
                                                <div class="absolute inset-0 bg-red-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl pointer-events-none"></div>

                                                @if($sponsor->logo)
                                                    <div class="h-20 w-full mb-4 flex items-center justify-center relative z-10">
                                                        <img src="{{ Str::startsWith($sponsor->logo, ['http://', 'https://']) ? $sponsor->logo : asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" class="max-h-full max-w-full object-contain filter drop-shadow-md group-hover:scale-110 transition-transform duration-500">
                                                    </div>
                                                @else
                                                    <div class="h-16 w-16 rounded-full bg-gray-700 mb-4 flex items-center justify-center border-2 border-dashed border-gray-600 group-hover:border-red-500 transition-colors relative z-10">
                                                        <i class="fas fa-building text-2xl text-gray-500 group-hover:text-red-400"></i>
                                                    </div>
                                                @endif
                                                <h4 class="text-lg font-bold text-gray-200 group-hover:text-white transition-colors relative z-10 mb-2">{{ $sponsor->name }}</h4>
                                                @if($sponsor->link)
                                                    <a href="{{ $sponsor->link }}" target="_blank" class="text-sm font-semibold text-red-500 hover:text-red-400 transition-colors inline-flex items-center relative z-10 mt-auto">Visit Site <i class="fas fa-external-link-alt ml-2 text-xs"></i></a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-8 p-1 rounded-xl bg-gradient-to-r from-red-600 via-yellow-500 to-red-600 animate-gradient-xy relative group shadow-2xl shadow-red-900/40">
                                <div class="p-5 sm:p-6 bg-gray-900 rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between h-full relative overflow-hidden">
                                    <!-- Glowing background effect -->
                                    <div class="absolute inset-0 bg-red-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                    <div class="relative z-10 w-full sm:w-auto text-center sm:text-left">
                                        <span class="text-[10px] sm:text-xs font-black tracking-widest text-red-500 uppercase mb-1 flex items-center justify-center sm:justify-start">
                                            <span class="relative flex h-3 w-3 mr-2">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                            </span>
                                            Sponsorship Available
                                        </span>
                                        <h3 class="text-xl sm:text-2xl font-black text-white group-hover:text-red-400 transition-colors">Become a Sponsor!</h3>
                                        <p class="text-xs sm:text-sm text-gray-400 mt-1 hidden sm:block">Want your brand here? Reach out to us now.</p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 relative z-10 w-full sm:w-auto">
                                        <a href="tel:{{ optional($site_setting)->contact_phone ?? '+880 1234 567890' }}" 
                                           class="flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg shadow-[0_0_15px_rgba(220,38,38,0.5)] hover:shadow-[0_0_25px_rgba(220,38,38,0.7)] transition-all duration-300 transform hover:-translate-y-1 w-full">
                                            <i class="fas fa-phone-volume text-white mr-3 animate-bounce-subtle"></i>
                                            <span class="text-white font-bold tracking-wide text-sm sm:text-lg">{{ optional($site_setting)->contact_phone ?? '+880 1234 567890' }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-6 md:mb-8 border-b border-gray-700 pb-4 md:pb-6">{{ $program->title }}</h1>

                        <div class="prose prose-invert prose-red max-w-none text-gray-300 leading-relaxed summernote-content text-lg mb-12">
                            {!! $program->description !!}
                        </div>

                        {{-- Registration Form --}}
                        @if($program->is_registration_active)
                            @php
        $isDeadlinePassed = $program->registration_deadline && \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($program->registration_deadline)->startOfDay());
                            @endphp

                            @if(!$isDeadlinePassed)
                                <div class="mt-8 md:mt-12 bg-gray-900/80 p-5 md:p-8 rounded-xl border border-red-500/20 shadow-2xl relative">
                                    <div class="absolute top-0 right-0 p-4 opacity-5">
                                        <i class="fas fa-edit text-8xl text-red-500"></i>
                                    </div>

                                <h2 class="text-xl md:text-3xl font-bold text-white mb-6 md:mb-8 flex items-center">
                                    <span class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-red-600/30">
                                        <i class="fas fa-file-signature text-sm"></i>
                                    </span>
                                    Register for {{ $program->title }}
                                </h2>

                                @if(session('success'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Swal.fire({
                                                title: 'সফল!',
                                                text: 'তোমার রেজিস্ট্রেশন সাকসেস হয়েছে, এডমিন এপ্রুভাল হলে এইখানে লিস্টে দেখতে পারবে। অন্যদের সাথে শেয়ার করার অনুরোধ রইলো',
                                                icon: 'success',
                                                background: '#111827',
                                                color: '#f3f4f6',
                                                confirmButtonColor: '#dc2626',
                                                confirmButtonText: 'ঠিক আছে',
                                                customClass: {
                                                    popup: 'rounded-2xl border border-gray-700 shadow-2xl shadow-red-900/20',
                                                    title: 'text-2xl font-bold',
                                                    confirmButton: 'rounded-xl px-8 py-3'
                                                }
                                            });
                                        });
                                    </script>
                                @endif

                                    @if($program->registration_fee > 0)
                                    <div class="bg-red-600/10 border border-red-600/20 p-5 md:p-6 rounded-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-10">
                                        <div class="flex items-center text-gray-400 font-medium text-sm md:text-base">
                                            <i class="fas fa-tags mr-3 text-red-500"></i>
                                            Registration Fee
                                        </div>
                                        <div class="text-xl md:text-2xl font-black text-white">
                                            {{ number_format($program->registration_fee, 2) }} BDT
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('programs.register', $program->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        @if($program->registration_fields)
                                            @foreach($program->registration_fields as $field)
                                                @php 
                                                    $isObject = is_array($field);
                    $label = $isObject ? ($field['name'] ?? '') : $field;
                    $type = $isObject ? ($field['type'] ?? 'text') : 'text';
                    $required = $isObject ? ($field['required'] ?? true) : true;
                    $fieldName = str_replace(' ', '_', strtolower($label));
                                                @endphp
                                                <div class="space-y-3 {{ $type == 'textarea' ? 'md:col-span-2' : '' }}">
                                                    <label for="{{ $fieldName }}" class="block text-sm font-bold text-gray-400 tracking-wider uppercase">
                                                        {{ $label }} 
                                                        @if($required) <span class="text-red-500">*</span> @endif
                                                    </label>

                                                    @if($type == 'textarea')
                                                        <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" {{ $required ? 'required' : '' }}
                                                        class="w-full bg-gray-800/50 border border-gray-700 rounded-xl py-3 md:py-4 px-4 md:px-5 text-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-300 placeholder-gray-600"
                                                        rows="4" placeholder="Enter {{ strtolower($label) }}"></textarea>
                                                    @elseif($type == 'photo')
                                                        <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}" {{ $required ? 'required' : '' }} accept="image/*"
                                                        class="w-full bg-gray-800/50 border border-gray-700 rounded-xl py-3 md:py-4 px-4 md:px-5 text-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                                                    @else
                                                        <input type="{{ $type }}" name="{{ $fieldName }}" id="{{ $fieldName }}" {{ $required ? 'required' : '' }}
                                                        class="w-full bg-gray-800/50 border border-gray-700 rounded-xl py-3 md:py-4 px-4 md:px-5 text-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition duration-300 placeholder-gray-600"
                                                        placeholder="Enter {{ strtolower($label) }}">
                                                    @endif

                                                    @error($fieldName)
                                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

    
                                    <div class="pt-6">
                                        <button type="submit" class="w-full md:w-auto px-8 md:px-12 py-3.5 md:py-5 bg-red-600 hover:bg-red-700 text-white font-black rounded-xl md:rounded-2xl transition duration-300 shadow-xl shadow-red-600/40 flex items-center justify-center group text-base md:text-lg">
                                            Submit Registration
                                            <svg class="w-5 h-5 md:w-6 md:h-6 ml-3 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </button>
                                    </div>
                                </form>
                                </div>
                            @else
                                <div class="mt-12 bg-red-900/40 border border-red-500/30 p-8 rounded-xl text-center">
                                    <i class="fas fa-exclamation-circle text-5xl text-red-500 mb-4"></i>
                                    <h3 class="text-2xl font-bold text-white mb-2">Registration Closed</h3>
                                    <p class="text-gray-300">The registration deadline for this program has passed. Please contact us for further information.</p>
                                    <div class="mt-6 flex justify-center space-x-4">
                                         <a href="{{ route('contact') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300">Contact Us</a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Sidebar --}}
            <div class="lg:w-80 space-y-6">
                <div class="lg:sticky lg:top-24">
                    {{-- Registrations List --}}
                    @if($program->registrations->count() > 0)
                                        @php
                        $registrationsData = [];
                        foreach ($program->registrations as $reg) {
                            $data = $reg->registration_data ?? [];
                            $name = 'N/A';
                            foreach ($data as $key => $val) {
                                if (\Illuminate\Support\Str::contains(strtolower($key), ['name', 'নাম'])) {
                                    $name = $val;
                                    break;
                                }
                            }
                            if ($name == 'N/A' && !empty($data)) {
                                $name = reset($data);
                            }

                            $mobile = '';
                            foreach ($data as $key => $val) {
                                if (\Illuminate\Support\Str::contains(strtolower($key), ['mobile', 'phone', 'মোবাইল'])) {
                                    $mobile = $val;
                                    break;
                                }
                            }

                            if ($mobile && strlen($mobile) >= 11) {
                                $maskedMobile = substr($mobile, 0, 5) . str_repeat('*', strlen($mobile) - 7) . substr($mobile, -2);
                            } else if ($mobile && strlen($mobile) >= 8) {
                                $maskedMobile = substr($mobile, 0, 3) . str_repeat('*', 3) . substr($mobile, -2);
                            } else {
                                $maskedMobile = $mobile;
                            }

                            $statusColor = $reg->status == 'accept' ? 'text-green-500' : ($reg->status == 'reject' ? 'text-red-500' : 'text-yellow-500');
                            $statusBadgeBg = $reg->status == 'accept' ? 'bg-green-500/10 border-green-500/30' : ($reg->status == 'reject' ? 'bg-red-500/10 border-red-500/30' : 'bg-yellow-500/10 border-yellow-500/30');

                            $registrationsData[] = [
                                'registration_id' => htmlspecialchars($reg->formatted_id),
                                'name' => htmlspecialchars($name),
                                'mobile' => htmlspecialchars($maskedMobile),
                                'status' => $reg->status,
                                'statusColor' => $statusColor,
                                'statusBadgeBg' => $statusBadgeBg
                            ];
                        }
                                        @endphp

                                        <div x-data="registrationList()" class="bg-gray-800 rounded-xl border border-gray-700 shadow-xl overflow-hidden mb-8">
                                            <div class="p-4 bg-gray-900 border-b border-gray-700 shrink-0">
                                                <h3 class="text-lg font-bold text-white flex items-center mb-3">
                                                    <i class="fas fa-users text-red-500 mr-2"></i> Registered Members (<span x-text="items.length"></span>)
                                                </h3>
                                                <div class="relative">
                                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                                    <input type="text" x-model="search" @input="page = 1" placeholder="Search by name, ID or number..." class="w-full bg-gray-800 border border-gray-600 rounded-lg py-2 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-red-500 transition placeholder-gray-500">
                                                </div>
                                            </div>

                                            <div class="divide-y divide-gray-700">
                                                <template x-for="(item, index) in paginatedItems" :key="index">
                                                    <div class="p-4 hover:bg-gray-700/30 transition group border-b border-gray-700 last:border-0 relative overflow-hidden">
                                                        <div class="flex justify-between items-center relative z-10">
                                                            {{-- Left: Name & Contact --}}
                                                            <div class="flex-1 min-w-0">
                                                                <h4 class="font-bold text-white text-sm md:text-base leading-tight group-hover:text-red-400 transition-colors truncate" x-html="item.name"></h4>
                                                                <template x-if="item.mobile">
                                                                    <div class="flex items-center text-xs text-gray-400 mt-1">
                                                                        <i class="fas fa-phone-alt text-[10px] text-red-500 mr-2"></i>
                                                                        <span x-html="item.mobile" class="tracking-widest"></span>
                                                                    </div>
                                                                </template>
                                                            </div>

                                                            {{-- Right: Status & ID --}}
                                                            <div class="flex flex-col items-end shrink-0 ml-4 py-1">
                                                                <span :class="`px-3 py-1 rounded-full text-[10px] border font-black uppercase tracking-widest leading-none ${item.statusColor} ${item.statusBadgeBg}`" 
                                                                      x-text="item.status"></span>
                                                                <div class="text-[11px] font-bold text-white mt-2 tracking-wide flex items-center" 
                                                                     x-show="item.registration_id">
                                                                     <span class="text-white text-[9px] mr-1">ID#</span>
                                                                     <span x-text="item.registration_id"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Subtle hover glow --}}
                                                        <div class="absolute inset-0 bg-gradient-to-r from-red-600/0 via-red-600/0 to-red-600/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                                    </div>
                                                </template>
                                                <div x-show="filteredItems.length === 0" class="p-8 text-center text-gray-500 text-sm" x-cloak>
                                                    No members found matching your search.
                                                </div>
                                            </div>

                                            <!-- Pagination -->
                                            <div x-show="totalPages > 1" class="p-3 bg-gray-900 border-t border-gray-700 flex justify-between items-center shrink-0" x-cloak>
                                                <button @click="page--" :disabled="page === 1" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded text-sm text-white transition disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <i class="fas fa-chevron-left mr-1"></i> Prev
                                                </button>
                                                <span class="text-xs text-gray-400">
                                                    Page <span x-text="page" class="text-white font-bold"></span> of <span x-text="totalPages" class="text-white font-bold"></span>
                                                </span>
                                                <button @click="page++" :disabled="page >= totalPages" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded text-sm text-white transition disabled:opacity-50 disabled:cursor-not-allowed">
                                                    Next <i class="fas fa-chevron-right ml-1"></i>
                                                </button>
                                            </div>
                                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
    <style>
    .summernote-content p { margin-bottom: 2rem; }
    .summernote-content ul { list-style-type: disc; margin-left: 2rem; margin-bottom: 2rem; }
    .summernote-content ol { list-style-type: decimal; margin-left: 2rem; margin-bottom: 2rem; }
    .animate-bounce-subtle {
        animation: bounce-subtle 3s infinite;
    }
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    @keyframes gradient-xy {
        0%, 100% { background-size: 400% 400%; background-position: left center; }
        50% { background-size: 200% 200%; background-position: right center; }
    }
    .animate-gradient-xy {
        animation: gradient-xy 3s ease infinite;
    }
    </style>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const banglaToEnglishMap = {'০':'0','১':'1','২':'2','৩':'3','৪':'4','৫':'5','৬':'6','৭':'7','৮':'8','৯':'9'};

        function convertBanglaToEnglish(str) {
            if(!str) return str;
            return str.replace(/[০-৯]/g, match => banglaToEnglishMap[match]);
        }

        // Apply generic conversion to all inputs
        const inputs = document.querySelectorAll('input[type="number"], input[type="text"], input[type="tel"]');
        inputs.forEach(input => {
            input.addEventListener('input', function(e) {
                const originalVal = e.target.value;
                const convertedVal = convertBanglaToEnglish(originalVal);
                if(originalVal !== convertedVal) {
                    e.target.value = convertedVal;
                }

                // If it's a transaction/trx field, restrict to english alpha-numeric
                const name = input.name.toLowerCase();
                if(name.includes('transaction') || name.includes('trx') || name.includes('id')) {
                    // remove non-alphanumeric except maybe hyphens if needed, but we used a-zA-Z0-9
                    e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '');
                }

                // Min amount validation on the frontend
                @if($program->registration_fee > 0)
                    const fee = {{ $program->registration_fee }};
                    if(name.includes('amount') || name.includes('fee') || name.includes('টাকা') || name.includes('আমাউন্ট')) {
                        if(parseFloat(e.target.value) < fee) {
                            e.target.setCustomValidity("Amount must be at least " + fee);
                        } else {
                            e.target.setCustomValidity("");
                        }
                    }
                @endif
            });
        });
    });

    function registrationList() {
        return {
            search: '',
            page: 1,
            perPage: 8,
            items: @json($registrationsData ?? []),
            get filteredItems() {
                if (this.search === '') return this.items;
                const s = this.search.toLowerCase();
                return this.items.filter(i => {
                    return (i.name && i.name.toLowerCase().includes(s)) || (i.mobile && i.mobile.includes(s)) || (i.registration_id && i.registration_id.toLowerCase().includes(s));
                });
            },
            get paginatedItems() {
                const start = (this.page - 1) * this.perPage;
                return this.filteredItems.slice(start, start + this.perPage);
            },
            get totalPages() {
                return Math.max(1, Math.ceil(this.filteredItems.length / this.perPage));
            }
        }
    }
    </script>
    @endpush
@endsection
