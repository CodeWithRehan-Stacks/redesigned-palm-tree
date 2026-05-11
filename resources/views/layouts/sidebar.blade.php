{{-- ── SIDEBAR ──────────────────────────────────────────────── --}}
<div x-data="{ open: false }" @open-sidebar.window="open = true" @keydown.escape.window="open = false">

    <!-- Mobile Overlay -->
    <div x-show="open"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 z-40 md:hidden"
         @click="open = false"
         style="display: none;"></div>

    <!-- Sidebar Panel -->
    <aside class="fixed top-0 left-0 z-50 h-screen w-[260px] bg-white border-r border-slate-200
                  flex flex-col transition-transform duration-300 ease-out md:translate-x-0
                  dark:bg-[#161b22] dark:border-slate-800 scrollbar-hide"
           :class="open ? 'translate-x-0' : '-translate-x-full'">

        <!-- Logo -->
        <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-sn-300 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-rounded text-[18px] text-sn-900" style="font-variation-settings: 'FILL' 1">auto_stories</span>
                </div>
                <span class="text-[17px] font-bold text-slate-900 dark:text-white tracking-tight">ShareNote</span>
            </a>
            <button class="md:hidden p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg" @click="open = false">
                <span class="material-symbols-rounded text-[20px]">close</span>
            </button>
        </div>

        <!-- Create Note CTA -->
        <div class="px-4 pt-4 pb-2">
            <a href="{{ route('notes.create') }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 bg-sn-300 hover:bg-sn-400 text-sn-900 font-semibold rounded-xl text-sm transition-colors duration-150">
                <span class="material-symbols-rounded text-[18px]">add</span>
                New Note
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-2 overflow-y-auto scrollbar-hide space-y-0.5">
            <p class="section-label mt-2 mb-1">Main</p>

            <a href="{{ route('home') }}"
               class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <span class="material-symbols-rounded text-[20px]" style="{{ request()->routeIs('home') ? 'font-variation-settings: \'FILL\' 1' : '' }}">home</span>
                Home Feed
            </a>

            <a href="{{ route('notes.index') }}"
               class="sidebar-link {{ request()->routeIs('notes.*') && !request()->routeIs('notes.create') ? 'active' : '' }}">
                <span class="material-symbols-rounded text-[20px]">article</span>
                My Notes
            </a>

            <a href="{{ route('notes.create') }}"
               class="sidebar-link {{ request()->routeIs('notes.create') ? 'active' : '' }}">
                <span class="material-symbols-rounded text-[20px]">edit_note</span>
                Write Note
            </a>

            <a href="#" class="sidebar-link">
                <span class="material-symbols-rounded text-[20px]">bookmark</span>
                Saved
            </a>

            <p class="section-label mt-4 mb-1">Explore</p>

            <a href="{{ route('explore') }}"
               class="sidebar-link {{ request()->routeIs('explore') ? 'active' : '' }}">
                <span class="material-symbols-rounded text-[20px]" style="{{ request()->routeIs('explore') ? 'font-variation-settings: \'FILL\' 1' : '' }}">explore</span>
                Discover
            </a>

            @if(auth()->user()->role === 'admin')
                <p class="section-label mt-4 mb-1">Admin</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <span class="material-symbols-rounded text-[20px]" style="{{ request()->routeIs('admin.*') ? 'font-variation-settings: \'FILL\' 1' : '' }}">admin_panel_settings</span>
                    Admin Panel
                </a>
            @endif
        </nav>

        <!-- Bottom Profile Strip (compact) -->
        <div class="px-3 py-3 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('profile.show', auth()->user()->username) }}"
               class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group">
                <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                     class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 object-cover flex-shrink-0" alt="">
                <div class="flex-1 overflow-hidden">
                    <p class="text-[13px] font-semibold text-slate-900 dark:text-white truncate leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-[12px] text-slate-400 truncate leading-tight">@{{ auth()->user()->username }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Sign out">
                        <span class="material-symbols-rounded text-[16px]">logout</span>
                    </button>
                </form>
            </a>
        </div>
    </aside>
</div>

<!-- Mobile top bar -->
<header class="md:hidden fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200 dark:bg-[#161b22] dark:border-slate-800 px-4 py-3 flex items-center justify-between">
    <button x-data @click="$dispatch('open-sidebar')" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-300 dark:hover:bg-slate-800">
        <span class="material-symbols-rounded text-[24px]">menu</span>
    </button>
    <a href="{{ route('home') }}" class="flex items-center gap-2">
        <div class="w-7 h-7 bg-sn-300 rounded-lg flex items-center justify-center">
            <span class="material-symbols-rounded text-[16px] text-sn-900" style="font-variation-settings: 'FILL' 1">auto_stories</span>
        </div>
        <span class="text-[16px] font-bold text-slate-900 dark:text-white">ShareNote</span>
    </a>
    <a href="{{ route('profile.show', auth()->user()->username) }}">
        <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
             class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700" alt="">
    </a>
</header>
