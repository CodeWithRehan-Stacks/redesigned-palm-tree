@extends('layouts.app')
@section('title', 'Explore ShareNote')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Explore</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Discover trending notes, top topics, and brilliant minds.</p>
    </div>

    {{-- Trending Sections Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        {{-- Left: Trending Notes --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-orange-500">local_fire_department</span>
                    Trending Notes
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($trendingNotes as $note)
                    <a href="{{ route('notes.show', $note->slug) }}" class="group block bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 hover:border-sn-400 dark:hover:border-sn-500 transition-all shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sn-600 bg-sn-50 dark:bg-sn-900/20 px-2 py-0.5 rounded-md">
                                {{ $note->category->name ?? 'General' }}
                            </span>
                            <span class="text-[11px] text-slate-400">{{ $note->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-sn-600 transition-colors line-clamp-1 mb-2">{{ $note->title }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4 leading-relaxed">
                            {{ strip_tags($note->content) }}
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center gap-2">
                                <img src="{{ $note->user->profile_picture ? Storage::url($note->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($note->user->name) }}" class="w-6 h-6 rounded-full">
                                <span class="text-xs font-medium text-slate-700 dark:text-slate-300">{{ $note->user->name }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-400">
                                <span class="flex items-center gap-1 text-[11px] font-medium">
                                    <span class="material-symbols-rounded text-[14px]">favorite</span>
                                    {{ $note->likes_count }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Right: Suggested Users --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-sn-600">person_add</span>
                    Top Contributors
                </h2>
            </div>
            <div class="bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($suggestedUsers as $sUser)
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('profile.show', $sUser->username) }}" class="relative">
                                    <img src="{{ $sUser->profile_picture ? Storage::url($sUser->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($sUser->name) }}" class="w-10 h-10 rounded-xl object-cover">
                                    @if($sUser->role === 'admin')
                                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-sn-600 text-white rounded-full flex items-center justify-center border-2 border-white dark:border-[#161b22]">
                                            <span class="material-symbols-rounded text-[8px]">verified</span>
                                        </span>
                                    @endif
                                </a>
                                <div class="min-w-0">
                                    <a href="{{ route('profile.show', $sUser->username) }}" class="block text-sm font-bold text-slate-900 dark:text-white truncate hover:underline">{{ $sUser->name }}</a>
                                    <p class="text-xs text-slate-500 truncate">{{ '@'.$sUser->username }}</p>
                                </div>
                            </div>
                            <x-follow-button :userId="$sUser->id" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Topics / Subjects --}}
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-rounded text-purple-500">grid_view</span>
                Top Subjects
            </h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($topTopics as $topic)
                <a href="{{ route('search', ['q' => $topic->name]) }}" class="group bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 text-center hover:bg-sn-50 dark:hover:bg-sn-900/10 hover:border-sn-300 transition-all shadow-sm">
                    <div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">{{ $topic->icon ?? '📄' }}</span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $topic->name }}</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ number_format($topic->notes_count) }} notes</p>
                </a>
            @endforeach
        </div>
    </div>

    {{-- General Feed --}}
    <div>
        <div class="flex items-center justify-between mb-6 border-b border-slate-200 dark:border-slate-800 pb-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-rounded text-blue-500">explore</span>
                Discover More
            </h2>
        </div>
        @include('profile.partials.notes_list', ['notes' => $notes])
    </div>

</div>
@endsection
