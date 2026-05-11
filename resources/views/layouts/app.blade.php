<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ShareNote — The social study platform for students and learners.">

    <title>{{ config('app.name', 'ShareNote') }} · @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('head')
</head>
<body class="bg-[#F5F5F5] text-slate-900 font-sans antialiased dark:bg-[#0d1117] dark:text-slate-100 overflow-x-hidden">

    <div class="min-h-screen flex relative">

        <!-- ── SIDEBAR ─────────────────────────────────────── -->
        @include('layouts.sidebar')

        <!-- ── MAIN CONTENT ───────────────────────────────── -->
        <div class="flex-1 flex flex-col min-w-0 md:pl-[260px]">

            <!-- Sticky Navbar -->
            @include('layouts.navbar')

            <!-- Page Content -->
            <main class="flex-1 px-4 pt-24 pb-6 sm:px-6 lg:px-8 max-w-[80rem] mx-auto w-full fade-in md:pt-6">
                <!-- Flash messages -->
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-medium dark:bg-emerald-900/20 dark:border-emerald-800 dark:text-emerald-400" role="alert">
                        <span class="material-symbols-rounded text-[18px]">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 text-sm font-medium dark:bg-red-900/20 dark:border-red-800 dark:text-red-400" role="alert">
                        <span class="material-symbols-rounded text-[18px]">error</span>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- ── MOBILE BOTTOM NAV ─────────────────────────────── -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 dark:bg-[#161b22] dark:border-slate-800">
        <div class="flex items-center justify-around py-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 py-1.5 px-4 {{ request()->routeIs('home') ? 'text-sn-600' : 'text-slate-500' }}">
                <span class="material-symbols-rounded text-[24px] {{ request()->routeIs('home') ? 'fill' : '' }}" style="{{ request()->routeIs('home') ? 'font-variation-settings: \'FILL\' 1' : '' }}">home</span>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="{{ route('notes.create') }}" class="flex flex-col items-center gap-0.5 py-1.5 px-4 text-slate-500">
                <span class="material-symbols-rounded text-[24px]">add_circle</span>
                <span class="text-[10px] font-medium">Create</span>
            </a>
            <a href="{{ route('profile.show', auth()->user()->username) }}" class="flex flex-col items-center gap-0.5 py-1.5 px-4 text-slate-500">
                <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}" class="w-6 h-6 rounded-full" alt="">
                <span class="text-[10px] font-medium">Profile</span>
            </a>
        </div>
    </nav>

    @stack('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('followStore', {
                following: @json(auth()->user() ? auth()->user()->following()->pluck('following_id') : []),
                
                isFollowing(userId) {
                    return this.following.includes(parseInt(userId));
                },
                
                toggle(userId) {
                    const id = parseInt(userId);
                    if (this.isFollowing(id)) {
                        this.following = this.following.filter(f => f !== id);
                    } else {
                        this.following.push(id);
                    }
                },

                sync(userId, state) {
                    const id = parseInt(userId);
                    const isFollowing = this.isFollowing(id);
                    if (state && !isFollowing) {
                        this.following.push(id);
                    } else if (!state && isFollowing) {
                        this.following = this.following.filter(f => f !== id);
                    }
                }
            });
        });
    </script>
</body>
</html>
