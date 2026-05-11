@extends('layouts.app')
@section('title', $note->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-400 overflow-x-auto whitespace-nowrap">
        <a href="{{ route('home') }}"
           class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
            Home
        </a>

        <span class="material-symbols-rounded text-[14px]">chevron_right</span>

        <a href="{{ route('profile.show', $note->user->username) }}"
           class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
            {{ $note->user->name }}
        </a>

        <span class="material-symbols-rounded text-[14px]">chevron_right</span>

        <span class="text-slate-600 dark:text-slate-300 font-medium truncate max-w-[220px]">
            {{ $note->title }}
        </span>
    </nav>

    {{-- Main Card --}}
    <article class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-[#0d1117]/80 backdrop-blur-xl shadow-[0_10px_50px_rgba(0,0,0,0.06)]">

        {{-- Glow --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 right-0 w-72 h-72 bg-[#5C919A]/10 blur-3xl rounded-full"></div>
        </div>

        <div class="relative p-6 sm:p-8">

            {{-- Author --}}
            <div class="flex items-start justify-between gap-4 mb-6">

                <div class="flex items-center gap-4">

                    <a href="{{ route('profile.show', $note->user->username) }}"
                       class="relative group">

                        <div class="absolute inset-0 rounded-3xl bg-[#5C919A]/20 blur-xl opacity-0 group-hover:opacity-100 transition duration-300"></div>

                        <img
                            src="{{ $note->user->profile_picture ? Storage::url($note->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($note->user->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                            class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-3xl object-cover ring-4 ring-white dark:ring-[#0d1117] shadow-xl"
                        >
                    </a>

                    <div>

                        <a href="{{ route('profile.show', $note->user->username) }}"
                           class="text-[16px] font-bold text-slate-900 dark:text-white hover:underline">
                            {{ $note->user->name }}
                        </a>

                        <div class="flex items-center gap-2 text-[13px] text-slate-400 mt-1">
                            <span>{{ '@' . $note->user->username }}</span>
                            <span>•</span>
                            <span>{{ $note->created_at->diffForHumans() }}</span>
                        </div>

                    </div>

                </div>

                @if(auth()->id() === $note->user_id)

                    <a href="{{ route('notes.edit', $note) }}"
                       class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-white/5 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-white hover:shadow-lg hover:scale-[1.02] transition-all duration-300">

                        <span class="material-symbols-rounded text-[18px]">
                            edit
                        </span>

                        Edit

                    </a>

                @endif

            </div>

            {{-- Category --}}
            @if($note->category)
                <div class="mb-5">
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#5C919A]/10 text-[#5C919A] dark:text-[#9FBFC5] px-4 py-2 text-xs font-bold border border-[#5C919A]/20">
                        <span>{{ $note->category->icon }}</span>
                        <span>{{ $note->category->name }}</span>
                    </span>
                </div>
            @endif

            {{-- Title --}}
            <h1 class="text-3xl sm:text-4xl font-black leading-tight tracking-tight text-slate-900 dark:text-white mb-5">
                {{ $note->title }}
            </h1>

            {{-- Tags --}}
            @if($note->tags->count())
                <div class="flex flex-wrap gap-2 mb-6">

                    @foreach($note->tags as $tag)

                        <span class="inline-flex items-center rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/70 px-3 py-1.5 text-[13px] font-medium text-[#5C919A] dark:text-[#9FBFC5] hover:scale-[1.03] transition-transform cursor-pointer">
                            #{{ $tag->name }}
                        </span>

                    @endforeach

                </div>
            @endif

            {{-- Cover --}}
            @if($note->cover_image)

                <div class="mb-7 overflow-hidden rounded-[1.8rem] border border-slate-200 dark:border-slate-700 shadow-xl">

                    <img
                        src="{{ Storage::url($note->cover_image) }}"
                        alt="Cover"
                        class="w-full max-h-[450px] object-cover hover:scale-[1.02] transition duration-500"
                    >

                </div>

            @endif

            {{-- Content --}}
            @if($note->content)

                <div class="prose prose-slate dark:prose-invert max-w-none prose-headings:font-bold prose-p:text-[16px] prose-p:leading-8 prose-img:rounded-2xl prose-pre:rounded-2xl mb-8">

                    {!! $note->content !!}

                </div>

            @else

                <div class="rounded-3xl border border-dashed border-slate-300 dark:border-slate-700 p-8 text-center">
                    <span class="material-symbols-rounded text-[42px] text-slate-300 dark:text-slate-600">
                        article
                    </span>

                    <p class="mt-3 text-slate-500 dark:text-slate-400 italic">
                        This note has no content yet.
                    </p>
                </div>

            @endif

            {{-- Attachments --}}
            @if($note->files->count())

                <div class="border-t border-slate-200 dark:border-slate-800 pt-7">

                    <div class="flex items-center justify-between mb-5">

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="material-symbols-rounded">
                                attach_file
                            </span>

                            Attachments
                        </h3>

                        <span class="text-sm text-slate-400">
                            {{ $note->files->count() }} files
                        </span>

                    </div>

                    <div class="space-y-3">

                        @foreach($note->files as $file)

                            <a href="{{ Storage::url($file->file_path) }}"
                               target="_blank"
                               class="group flex items-center gap-4 rounded-3xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-[#111827]/70 p-4 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">

                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center
                                    {{ in_array(strtolower($file->file_type), ['pdf']) ? 'bg-red-100 dark:bg-red-900/20 text-red-500' : 'bg-blue-100 dark:bg-blue-900/20 text-blue-500' }}">

                                    <span class="material-symbols-rounded text-[28px]"
                                          style="font-variation-settings: 'FILL' 1">

                                        {{ in_array(strtolower($file->file_type), ['pdf']) ? 'picture_as_pdf' : 'description' }}

                                    </span>

                                </div>

                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold text-slate-900 dark:text-white truncate group-hover:text-[#5C919A] transition-colors">
                                        {{ $file->original_name }}
                                    </p>

                                    <p class="text-sm text-slate-400 mt-1">
                                        {{ strtoupper($file->file_type) }}
                                        •
                                        {{ $file->size ? number_format($file->size / 1024, 0) . ' KB' : 'Unknown size' }}
                                    </p>

                                </div>

                                <span class="material-symbols-rounded text-slate-400 group-hover:text-[#5C919A] transition">
                                    download
                                </span>

                            </a>

                        @endforeach

                    </div>

                </div>

            @endif

            {{-- Stats --}}
            <div class="border-t border-slate-200 dark:border-slate-800 mt-8 pt-6 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex flex-wrap items-center gap-5 text-sm text-slate-500 dark:text-slate-400">

                    <span class="flex items-center gap-2">
                        <span class="material-symbols-rounded text-[18px]">
                            visibility
                        </span>

                        {{ number_format($note->views_count) }} views
                    </span>

                    <span class="flex items-center gap-2">
                        <span class="material-symbols-rounded text-[18px] text-red-500">
                            favorite
                        </span>

                        {{ number_format($note->likes_count) }} likes
                    </span>

                    <span class="flex items-center gap-2">
                        <span class="material-symbols-rounded text-[18px]">
                            bookmark
                        </span>

                        {{ number_format($note->saves_count) }} saves
                    </span>

                </div>

                {{-- Actions --}}
                <div class="flex flex-wrap items-center gap-3">

                    <button class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-white/5 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-900/20 transition-all">

                        <span class="material-symbols-rounded text-[18px]">
                            favorite_border
                        </span>

                        Like

                    </button>

                    <button class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-white/5 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                        <span class="material-symbols-rounded text-[18px]">
                            bookmark_border
                        </span>

                        Save

                    </button>

                    <button class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-white/5 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">

                        <span class="material-symbols-rounded text-[18px]">
                            share
                        </span>

                        Share

                    </button>

                </div>

            </div>

        </div>
    </article>

</div>
@endsection