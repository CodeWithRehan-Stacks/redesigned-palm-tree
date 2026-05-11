{{-- ── TOP NAVBAR — single search, clean, sticky ─────────── --}}
<header class="hidden md:flex sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200
               dark:bg-[#161b22]/95 dark:border-slate-800 px-6 py-3 items-center gap-4">

    <!-- Global Search -->
    <form action="{{ route('search') }}" method="GET" x-data="{ focused: false, query: '{{ request('q') }}' }" class="flex-1 max-w-xl relative">
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-rounded text-[18px] text-slate-400"
                  :class="focused ? 'text-sn-600' : ''">search</span>
            <input
                type="text"
                name="q"
                x-model="query"
                @focus="focused = true"
                @blur="focused = false"
                placeholder="Search notes, topics, people…"
                class="w-full bg-slate-100 border border-transparent rounded-xl py-2 pl-10 pr-10 text-sm
                       focus:outline-none focus:bg-white focus:border-sn-400 focus:ring-2 focus:ring-sn-200
                       transition-all duration-150 placeholder:text-slate-400
                       dark:bg-slate-800 dark:border-slate-700 dark:text-white dark:focus:bg-slate-700 dark:focus:border-sn-500">
        </div>

        <!-- Search dropdown hint (appears when focused & query) -->
        <div x-show="focused && query.length > 0"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute top-full mt-2 left-0 right-0 bg-white border border-slate-200 rounded-xl shadow-lg
                    py-2 z-50 dark:bg-[#161b22] dark:border-slate-700"
             style="display: none;">
            <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Suggestions</div>
            <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-rounded text-[18px] text-slate-400">article</span>
                <span class="text-sm text-slate-700 dark:text-slate-300">Search notes for "<span x-text="query" class="font-semibold"></span>"</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-rounded text-[18px] text-slate-400">person_search</span>
                <span class="text-sm text-slate-700 dark:text-slate-300">Find people matching "<span x-text="query" class="font-semibold"></span>"</span>
            </a>
        </div>
    </form>

    <!-- Right Actions -->
    <div class="flex items-right gap-5">

        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.outside="open = false"
                    class="relative p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl
                           transition-colors dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800">
                <span class="material-symbols-rounded text-[22px]">notifications</span>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-[#161b22]"></span>
                @endif
            </button>

            <!-- Notifications Dropdown -->
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                 class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl z-50
                        dark:bg-[#161b22] dark:border-slate-700 overflow-hidden"
                 style="display: none;">

                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <p class="font-semibold text-sm text-slate-900 dark:text-white">Notifications</p>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <a href="#" class="text-xs text-sn-600 hover:text-sn-700 font-medium dark:text-sn-300">Mark all read</a>
                    @endif
                </div>

                <div class="max-h-72 overflow-y-auto">
                    @forelse(auth()->user()->notifications->take(6) as $notif)
                        <a href="{{ route('profile.show', $notif->data['follower_username']) }}"
                           class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors
                                  {{ is_null($notif->read_at) ? 'bg-sn-50 dark:bg-sn-900/10' : '' }}">
                            <img src="{{ $notif->data['follower_avatar'] ? Storage::url($notif->data['follower_avatar']) : 'https://ui-avatars.com/api/?name='.urlencode($notif->data['follower_name']).'&background=BBD5DA&color=1A3A3E' }}"
                                 class="avatar-sm flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-700 dark:text-slate-300 leading-snug">
                                    <span class="font-semibold text-slate-900 dark:text-white">{{ $notif->data['follower_name'] }}</span>
                                    {{ $notif->data['message'] }}
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                            @if(is_null($notif->read_at))
                                <div class="w-2 h-2 rounded-full bg-sn-500 flex-shrink-0 mt-1.5"></div>
                            @endif
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <span class="material-symbols-rounded text-[36px] text-slate-300 dark:text-slate-600">notifications_off</span>
                            <p class="text-sm text-slate-400 mt-2">All caught up!</p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800">
                    <a href="#" class="block px-4 py-2.5 text-center text-sm font-medium text-sn-600 hover:bg-slate-50 dark:text-sn-300 dark:hover:bg-slate-800 transition-colors">
                        View all notifications
                    </a>
                </div>
            </div>
        </div>

        <!-- Create Note shortcut -->
        <a href="{{ route('notes.create') }}"
           class="hidden sm:flex items-center gap-1.5 bg-sn-300 hover:bg-sn-400 text-sn-900 font-semibold
                  px-4 py-2 rounded-xl text-sm transition-colors duration-150">
            <span class="material-symbols-rounded text-[18px]">add</span>
            New Note
        </a>

        <!-- Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.outside="open = false"
                    class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                     class="w-8 h-8 rounded-lg object-cover border border-slate-200 dark:border-slate-700" alt="">
                <span class="material-symbols-rounded text-[16px] text-slate-400">expand_more</span>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute right-0 mt-2 w-52 bg-white border border-slate-200 rounded-2xl shadow-xl z-50
                        dark:bg-[#161b22] dark:border-slate-700 overflow-hidden py-1"
                 style="display: none;">

                <!-- User identity -->
                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ '@'.auth()->user()->username }}</p>
                </div>

                <a href="{{ route('profile.show', auth()->user()->username) }}"
                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-rounded text-[18px] text-slate-400">person</span>
                    Your Profile
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-rounded text-[18px] text-slate-400">settings</span>
                    Settings
                </a>

                <a href="{{ route('notes.index') }}"
                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-rounded text-[18px] text-slate-400">article</span>
                    My Notes
                </a>

          

                <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2.5 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <span class="material-symbols-rounded text-[18px]">logout</span>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
