@extends('layouts.app')
@section('title', 'Home Feed')

@section('content')
<div class="space-y-6">

    {{-- Hero Section --}}
    <section class="relative overflow-hidden rounded-[2rem] border border-slate-200/70 dark:border-slate-800 bg-white/80 dark:bg-[#0d1117]/80 backdrop-blur-xl shadow-[0_10px_60px_rgba(0,0,0,0.06)]">

        {{-- Background Glow --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -left-10 w-72 h-72 bg-[#5C919A]/20 blur-3xl rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-[#9FBFC5]/20 blur-3xl rounded-full"></div>
        </div>

        <div class="relative p-6 lg:p-10">
            <div class="grid gap-8 lg:grid-cols-[1.8fr_1fr] items-start">

                {{-- Left Content --}}
                <div class="space-y-7">

                    {{-- Headline --}}
                    <div class="space-y-4 max-w-3xl">
                        <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-white/5 px-4 py-2 text-xs font-semibold tracking-[0.2em] uppercase text-slate-500 dark:text-slate-400 backdrop-blur-xl">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Student-first study hub
                        </span>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-slate-900 dark:text-white">
                            Learn smarter with
                            <span class="bg-gradient-to-r from-[#5C919A] to-[#7BA8AF] bg-clip-text text-transparent">
                                premium study notes
                            </span>
                        </h1>

                        <p class="text-base sm:text-lg leading-relaxed text-slate-600 dark:text-slate-400 max-w-2xl">
                            Discover summaries, lecture notes, exam prep material, and curated resources shared by top-performing students worldwide.
                        </p>
                    </div>

                    {{-- Stats --}}
                    <div class="grid gap-4 sm:grid-cols-2">

                        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-[#111827]/70 backdrop-blur-xl p-5 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">
                                        Active notes
                                    </p>

                                    <p class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                                        {{ number_format($notes->total()) }}
                                    </p>
                                </div>

                                <div class="w-14 h-14 rounded-2xl bg-[#5C919A]/10 flex items-center justify-center">
                                    <span class="material-symbols-rounded text-[#5C919A] text-[28px]">
                                        auto_stories
                                    </span>
                                </div>
                            </div>

                            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                                Fresh study material uploaded daily by the community.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-[#111827]/70 backdrop-blur-xl p-5 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">
                                        Community picks
                                    </p>

                                    <p class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                                        {{ count($suggestedUsers) + count($trendingCategories) }}
                                    </p>
                                </div>

                                <div class="w-14 h-14 rounded-2xl bg-[#5C919A]/10 flex items-center justify-center">
                                    <span class="material-symbols-rounded text-[#5C919A] text-[28px]">
                                        groups
                                    </span>
                                </div>
                            </div>

                            <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                                Trending creators, categories and collaborative spaces.
                            </p>
                        </div>

                    </div>

                    {{-- Search --}}
                    <form action="{{ route('search') }}" method="GET" class="relative max-w-3xl">

                        <div class="relative overflow-hidden rounded-[1.8rem] border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-[#0d1117]/90 backdrop-blur-xl shadow-lg">

                            <span class="material-symbols-rounded absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                                search
                            </span>

                            <input
                                type="text"
                                name="q"
                                placeholder="Search notes, subjects, universities, professors..."
                                class="w-full bg-transparent pl-14 pr-32 py-5 text-sm sm:text-base text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none"
                                value="{{ request('q') }}"
                            >

                            <button
                                type="submit"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-2xl bg-gradient-to-r from-[#5C919A] to-[#6FA4AC] px-5 py-3 text-sm font-semibold text-white shadow-lg hover:scale-[1.02] transition-all duration-300"
                            >
                                Search
                            </button>

                        </div>
                    </form>

                    {{-- Trending Categories --}}
                    <div class="flex flex-wrap gap-3">
                        @foreach($trendingCategories as $category)
                            <a href="{{ route('search', ['q' => $category->name]) }}"
                               class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-white/5 backdrop-blur-xl px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:scale-[1.03] hover:shadow-lg transition-all duration-300">

                                <span>{{ $category->icon }}</span>
                                <span>{{ $category->name }}</span>

                            </a>
                        @endforeach
                    </div>

                </div>

                {{-- Right Panel --}}
                <div class="relative">

                    <div class="rounded-[2rem] border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-[#111827]/70 backdrop-blur-2xl p-6 shadow-xl">

                        {{-- Featured Creators --}}
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                        Featured creators
                                    </h3>

                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                        Follow top students and unlock premium notes.
                                    </p>
                                </div>

                                <div class="w-12 h-12 rounded-2xl bg-[#5C919A]/10 flex items-center justify-center">
                                    <span class="material-symbols-rounded text-[#5C919A]">
                                        workspace_premium
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-4">

                                @foreach($suggestedUsers as $suggested)

                                    <a href="{{ route('profile.show', $suggested->username) }}"
                                       class="group flex items-center gap-3 rounded-3xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-[#0d1117]/80 p-4 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">

                                        <div class="relative">

                                            <img
                                                src="{{ $suggested->profile_picture ? Storage::url($suggested->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($suggested->name).'&background=DFF1F1&color=1A3A3E&size=64' }}"
                                                class="w-14 h-14 rounded-2xl object-cover ring-2 ring-white dark:ring-slate-900 shadow-lg"
                                            >

                                            <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900"></span>

                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <p class="font-bold text-slate-900 dark:text-white truncate">
                                                {{ $suggested->name }}
                                            </p>

                                            <p class="text-sm text-slate-500 dark:text-slate-400 truncate">
                                                {{ '@' . $suggested->username }}
                                            </p>
                                        </div>

                                        <span class="material-symbols-rounded text-slate-300 group-hover:text-[#5C919A] transition">
                                            arrow_forward
                                        </span>

                                    </a>

                                @endforeach

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
@endsection