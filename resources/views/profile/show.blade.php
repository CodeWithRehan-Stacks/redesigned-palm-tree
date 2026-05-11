@extends('layouts.app')
@section('title', $user->name . ' (@' . $user->username . ')')

@section('content')
<div class="max-w-[720px] mx-auto">

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-medium dark:bg-emerald-900/20 dark:border-emerald-800 dark:text-emerald-400">
            <span class="material-symbols-rounded text-[16px]">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile Card --}}
    <div class="card overflow-hidden mb-4">

        {{-- Banner --}}
        <div class="h-40 w-full bg-gradient-to-r from-sn-100 to-sn-200 dark:from-sn-900/20 dark:to-sn-900/40 relative">
            @if($user->banner_image)
                <img src="{{ Storage::url($user->banner_image) }}" class="w-full h-full object-cover" alt="Banner">
            @endif
        </div>

        <div class="px-6 pb-6" x-data="{ 
             followersCount: {{ $user->followers_count }},
             followingCount: {{ $user->following_count }}
        }" 
             @follow-updated.window="if ($event.detail.userId === {{ $user->id }}) followersCount = $event.detail.followersCount">
          {{-- Avatar + Actions --}}
<div class="flex items-end justify-between -mt-16 mb-5 relative z-10">

    {{-- Profile Picture --}}
    <div class="relative group">

        {{-- Glow Effect --}}
        <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-sn-400/40 to-sn-600/40 blur-xl scale-110 opacity-70 group-hover:opacity-100 transition duration-500"></div>

        {{-- Avatar Container --}}
        <div class="relative p-1.5 bg-white/90 dark:bg-[#0d1117]/90 backdrop-blur-xl rounded-3xl border border-white/40 dark:border-white/10 shadow-2xl">

            <img 
                src="{{ $user->profile_picture 
                    ? Storage::url($user->profile_picture) 
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=BBD5DA&color=1A3A3E&size=256' }}"
                class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl object-cover ring-4 ring-white dark:ring-[#0d1117] shadow-xl transition duration-300 group-hover:scale-[1.03]"
                alt="{{ $user->name }}"
            >

            {{-- Online Dot --}}
            <div class="absolute bottom-3 right-3 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white dark:border-[#0d1117] shadow-md"></div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mt-14 flex items-center gap-2">
        @auth
            @if(auth()->id() === $user->id)
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center gap-2 bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-200 dark:border-slate-700 hover:border-sn-400 dark:hover:border-sn-500 text-slate-700 dark:text-white text-sm font-semibold py-2.5 px-4 rounded-2xl transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                    <span class="material-symbols-rounded text-[18px]">edit</span>
                    Edit Profile
                </a>
            @else
                <x-follow-button :userId="$user->id" variant="profile" />
            @endif
        @endauth
    </div>
</div>

            {{-- Name & Identity --}}
            <div class="mb-3">
                <div class="flex items-center gap-1.5">
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">{{ $user->name }}</h1>
                    @if($user->role === 'admin')
                        <span class="material-symbols-rounded text-sn-600 text-[18px]" title="Verified Admin">verified</span>
                    @endif
                </div>
                <p class="text-sm text-slate-400">{{ '@' . $user->username }}</p>
            </div>

            {{-- Bio --}}
            @if($user->bio)
                <p class="text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed mb-3">{{ $user->bio }}</p>
            @endif

            {{-- Meta info --}}
            <div class="flex flex-wrap items-center gap-4 text-[13px] text-slate-400 mb-4">
                @if($user->university)
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-rounded text-[16px]">school</span>
                        {{ $user->university }}
                    </span>
                @endif
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-rounded text-[16px]">calendar_month</span>
                    Joined {{ $user->created_at->format('F Y') }}
                </span>
            </div>

            {{-- Stats & Modal Controller --}}
            <div x-data="{ 
                modalOpen: false, 
                modalType: '', 
                modalUsers: [], 
                modalLoading: false,
                async showModal(type) {
                    this.modalType = type;
                    this.modalOpen = true;
                    this.modalLoading = true;
                    this.modalUsers = [];
                    try {
                        const response = await axios.get(`/users/{{ $user->id }}/${type}`);
                        this.modalUsers = response.data.data;
                    } catch (error) {
                        console.error('Failed to fetch users:', error);
                    } finally {
                        this.modalLoading = false;
                    }
                }
            }">
                <div class="flex items-center gap-5 text-sm">
                    <button @click="showModal('following')" class="hover:underline">
                        <span class="font-bold text-slate-900 dark:text-white" 
                              x-text="{{ auth()->id() === $user->id ? '$store.followStore.following.length' : followingCount }}">
                            {{ number_format($user->following_count) }}
                        </span>
                        <span class="text-slate-400 ml-1">Following</span>
                    </button>
                    <button @click="showModal('followers')" class="hover:underline">
                        <span class="font-bold text-slate-900 dark:text-white" x-text="followersCount.toLocaleString()">{{ number_format($user->followers_count) }}</span>
                        <span class="text-slate-400 ml-1">Followers</span>
                    </button>
                    <div>
                        <span class="font-bold text-slate-900 dark:text-white">{{ number_format($user->notes_count) }}</span>
                        <span class="text-slate-400 ml-1">Notes</span>
                    </div>
                </div>

                {{-- Modal Backdrop --}}
                <template x-teleport="body">
                    <div x-show="modalOpen" 
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click.self="modalOpen = false"
                         style="display: none;">
                        
                        <div class="bg-white dark:bg-[#161b22] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                            
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white capitalize" x-text="modalType"></h3>
                                <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </div>

                            <div class="max-h-[400px] overflow-y-auto px-6 py-4">
                                <template x-if="modalLoading">
                                    <div class="flex justify-center py-8">
                                        <svg class="animate-spin h-8 w-8 text-sn-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </template>

                                <template x-if="!modalLoading && modalUsers.length === 0">
                                    <p class="text-center text-slate-500 py-8">No users found.</p>
                                </template>

                                <div class="space-y-4">
                                    <template x-for="u in modalUsers" :key="u.id">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <a :href="'/@' + u.username">
                                                    <img :src="u.profile_picture ? '/storage/' + u.profile_picture : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(u.name) + '&background=DFF1F1&color=1A3A3E'"
                                                         class="w-10 h-10 rounded-xl object-cover">
                                                </a>
                                                <div class="min-w-0">
                                                    <a :href="'/@' + u.username" class="text-sm font-bold text-slate-900 dark:text-white hover:underline truncate block" x-text="u.name"></a>
                                                    <p class="text-xs text-slate-500 truncate" x-text="'@' + u.username"></p>
                                                </div>
                                            </div>
                                            <template x-if="u.id !== {{ auth()->id() }}">
                                                <x-follow-button userId="u.id" />
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Profile Tabs --}}
        <div class="flex border-t border-slate-200 dark:border-slate-800">
            <a href="{{ route('profile.show', ['username' => $user->username, 'tab' => 'notes']) }}" 
               class="flex-1 py-3 text-center text-sm font-semibold {{ $tab === 'notes' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border-b-2 border-transparent' }}">
                Notes
            </a>
            <a href="{{ route('profile.show', ['username' => $user->username, 'tab' => 'liked']) }}" 
               class="flex-1 py-3 text-center text-sm font-semibold {{ $tab === 'liked' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border-b-2 border-transparent' }}">
                Likes
            </a>
            <a href="{{ route('profile.show', ['username' => $user->username, 'tab' => 'saved']) }}" 
               class="flex-1 py-3 text-center text-sm font-semibold {{ $tab === 'saved' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 border-b-2 border-transparent' }}">
                Saved
            </a>
        </div>
    </div>

    {{-- Notes list --}}
    @include('profile.partials.notes_list', ['notes' => $notes, 'user' => $user, 'tab' => $tab])

</div>
@endsection
