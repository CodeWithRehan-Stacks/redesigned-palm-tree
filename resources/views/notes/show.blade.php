@extends('layouts.app')
@section('title', $note->title)

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Home</a>
        <span class="material-symbols-rounded text-[14px]">chevron_right</span>
        <a href="{{ route('profile.show', $note->user->username) }}" class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">{{ $note->user->name }}</a>
        <span class="material-symbols-rounded text-[14px]">chevron_right</span>
        <span class="text-slate-600 dark:text-slate-300 font-medium truncate max-w-[200px]">{{ $note->title }}</span>
    </nav>

    {{-- Note Card --}}
    <article class="card-p mb-6">

        {{-- Author + meta --}}
        <div class="flex items-start justify-between mb-5">
            <div class="flex items-center gap-3">
                <a href="{{ route('profile.show', $note->user->username) }}">
                    <img src="{{ $note->user->profile_picture ? Storage::url($note->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($note->user->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                         class="avatar-md">
                </a>
                <div>
                    <a href="{{ route('profile.show', $note->user->username) }}"
                       class="text-[15px] font-semibold text-slate-900 dark:text-white hover:underline">{{ $note->user->name }}</a>
                    <div class="flex items-center gap-2 text-[13px] text-slate-400">
                        <span>@{{ $note->user->username }}</span>
                        <span>·</span>
                        <span>{{ $note->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            @if(auth()->id() === $note->user_id)
                <div class="flex items-center gap-2">
                    <a href="{{ route('notes.edit', $note) }}" class="btn-secondary text-sm py-2 px-4">
                        <span class="material-symbols-rounded text-[16px]">edit</span>
                        Edit
                    </a>
                </div>
            @endif
        </div>

        {{-- Category badge --}}
        @if($note->category)
            <span class="badge-study text-[11px] mb-4 inline-flex">
                {{ $note->category->icon }} {{ $note->category->name }}
            </span>
        @endif

        {{-- Title --}}
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white leading-snug mb-3">{{ $note->title }}</h1>

        {{-- Tags --}}
        @if($note->tags->count())
            <div class="flex flex-wrap gap-1.5 mb-5">
                @foreach($note->tags as $tag)
                    <span class="text-[13px] text-[#5C919A] dark:text-[#9FBFC5] font-medium hover:underline cursor-pointer">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        {{-- Cover image --}}
        @if($note->cover_image)
            <div class="rounded-xl overflow-hidden mb-5 border border-slate-200 dark:border-slate-700">
                <img src="{{ Storage::url($note->cover_image) }}" alt="Cover" class="w-full max-h-80 object-cover">
            </div>
        @endif

        {{-- Rich text content --}}
        @if($note->content)
            <div class="prose prose-slate max-w-none dark:prose-invert mb-6 text-[15px] leading-relaxed">
                {!! $note->content !!}
            </div>
        @else
            <p class="text-slate-400 italic mb-6">This note has no content yet.</p>
        @endif

        {{-- File Attachments --}}
        @if($note->files->count())
            <div class="border-t border-slate-100 dark:border-slate-800 pt-5">
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 flex items-center gap-2">
                    <span class="material-symbols-rounded text-[18px]">attach_file</span>
                    Attachments ({{ $note->files->count() }})
                </h3>
                <div class="space-y-2">
                    @foreach($note->files as $file)
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                           class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800
                                  border border-slate-200 dark:border-slate-700 rounded-xl transition-colors group">
                            <div class="p-2 rounded-lg flex-shrink-0
                                {{ in_array(strtolower($file->file_type), ['pdf']) ? 'bg-red-100 dark:bg-red-900/20 text-red-500' : 'bg-blue-100 dark:bg-blue-900/20 text-blue-500' }}">
                                <span class="material-symbols-rounded text-[20px]" style="font-variation-settings: 'FILL' 1">
                                    {{ in_array(strtolower($file->file_type), ['pdf']) ? 'picture_as_pdf' : 'description' }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[14px] font-medium text-slate-900 dark:text-white truncate group-hover:text-[#5C919A] transition-colors">
                                    {{ $file->original_name }}
                                </p>
                                <p class="text-[12px] text-slate-400">
                                    {{ strtoupper($file->file_type) }} ·
                                    {{ $file->size ? number_format($file->size / 1024, 0) . ' KB' : 'Unknown size' }}
                                </p>
                            </div>
                            <span class="material-symbols-rounded text-[18px] text-slate-400 group-hover:text-[#5C919A] transition-colors">download</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Stats bar --}}
        <div class="border-t border-slate-100 dark:border-slate-800 mt-5 pt-4
                    flex items-center justify-between text-[13px] text-slate-400">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-rounded text-[16px]">visibility</span>
                    {{ number_format($note->views_count) }} views
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-rounded text-[16px]">favorite</span>
                    {{ number_format($note->likes_count) }} likes
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="material-symbols-rounded text-[16px]">bookmark</span>
                    {{ number_format($note->saves_count) }} saves
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button class="feed-action-btn hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                    <span class="material-symbols-rounded text-[18px]">favorite_border</span>
                    Like
                </button>
                <button class="feed-action-btn">
                    <span class="material-symbols-rounded text-[18px]">bookmark_border</span>
                    Save
                </button>
                <button class="feed-action-btn">
                    <span class="material-symbols-rounded text-[18px]">share</span>
                    Share
                </button>
            </div>
        </div>
    </article>

    {{-- Comments --}}
    <div class="card-p">
        <h2 class="text-[16px] font-bold text-slate-900 dark:text-white mb-5">
            Comments ({{ $note->comments->count() }})
        </h2>

        {{-- Add comment --}}
        <div class="flex items-start gap-3 mb-6">
            <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                 class="avatar-sm">
            <div class="flex-1 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden focus-within:border-[#9FBFC5] focus-within:ring-2 focus-within:ring-[#DFF1F1] transition-all">
                <textarea rows="2" placeholder="Write a comment…"
                          class="w-full bg-transparent border-none focus:ring-0 resize-none text-sm text-slate-900 dark:text-white px-4 pt-3 pb-0 placeholder:text-slate-400"></textarea>
                <div class="flex justify-end px-3 pb-3 pt-2">
                    <button class="btn-primary text-sm py-1.5 px-4">Post</button>
                </div>
            </div>
        </div>

        {{-- Comments list --}}
        @forelse($note->comments as $comment)
            <div class="flex items-start gap-3 pb-4 mb-4 border-b border-slate-100 dark:border-slate-800 last:border-0 last:mb-0 last:pb-0">
                <a href="{{ route('profile.show', $comment->user->username) }}">
                    <img src="{{ $comment->user->profile_picture ? Storage::url($comment->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                         class="avatar-sm">
                </a>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <a href="{{ route('profile.show', $comment->user->username) }}"
                           class="text-[14px] font-semibold text-slate-900 dark:text-white hover:underline">{{ $comment->user->name }}</a>
                        <span class="text-[12px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[14px] text-slate-700 dark:text-slate-300 leading-relaxed">{{ $comment->comment }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <span class="material-symbols-rounded text-[36px] text-slate-300 dark:text-slate-600">chat_bubble_outline</span>
                <p class="text-sm text-slate-400 mt-2">Be the first to comment!</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
