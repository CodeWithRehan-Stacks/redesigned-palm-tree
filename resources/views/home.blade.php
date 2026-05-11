@extends('layouts.app')
@section('title', 'Home Feed')

@section('content')
<div class="flex gap-8 pt-2">

    {{-- ── MAIN FEED ─────────────────────────────────────────── --}}
    <div class="flex-1 max-w-[600px] w-full">

        {{-- Compose Bar --}}
        <div class="card-p mb-6">
            <div class="flex items-start gap-3">
                <a href="{{ route('profile.show', auth()->user()->username) }}" class="flex-shrink-0">
                    <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                         class="avatar-md flex-shrink-0">
                </a>
                <div class="flex-1">
                    <textarea class="w-full bg-transparent border-none focus:ring-0 resize-none text-[15px]
                                     placeholder:text-slate-400 text-slate-900 dark:text-white min-h-[52px] p-0 leading-relaxed"
                              rows="2"
                              placeholder="Share a note, ask a question, start a discussion…"></textarea>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-1 text-slate-400">
                            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg hover:text-sn-600 transition-colors" title="Image">
                                <span class="material-symbols-rounded text-[20px]">image</span>
                            </button>
                            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg hover:text-sn-600 transition-colors" title="Attach file">
                                <span class="material-symbols-rounded text-[20px]">attach_file</span>
                            </button>
                            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg hover:text-sn-600 transition-colors" title="Add tag">
                                <span class="material-symbols-rounded text-[20px]">tag</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('notes.create') }}" class="text-sm text-sn-600 hover:text-sn-700 font-medium dark:text-sn-300">
                                Full editor
                            </a>
                            <button class="btn-primary py-2 px-5 text-sm rounded-xl">Post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Feed Tabs --}}
        <div class="flex items-center border-b border-slate-200 dark:border-slate-800 mb-4">
            <a href="{{ route('home', ['feed' => 'trending']) }}" 
               class="px-1 py-3 mr-6 text-sm font-semibold {{ $feed === 'trending' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 border-b-2 border-transparent' }}">
                For You
            </a>
            <a href="{{ route('home', ['feed' => 'following']) }}" 
               class="px-1 py-3 mr-6 text-sm font-semibold {{ $feed === 'following' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 border-b-2 border-transparent' }}">
                Following
            </a>
        </div>

        {{-- Feed Items --}}
        <div class="space-y-3">
            @forelse($notes as $note)
                <article class="feed-card group">
                    <div class="p-5">
                        {{-- Author row --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('profile.show', $note->user->username) }}">
                                    <img src="{{ $note->user->profile_picture ? Storage::url($note->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($note->user->name).'&background=DFF1F1&color=1A3A3E&size=64' }}"
                                         class="avatar-md">
                                </a>
                                <div>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('profile.show', $note->user->username) }}"
                                           class="text-[15px] font-semibold text-slate-900 dark:text-white hover:underline">{{ $note->user->name }}</a>
                                        @if($note->user->is_verified)
                                            <span class="material-symbols-rounded text-[14px] text-sn-500" style="font-variation-settings: 'FILL' 1">verified</span>
                                        @endif
                                    </div>
                                    <p class="text-[13px] text-slate-400">{{ '@' . $note->user->username }} · {{ $note->created_at->diffForHumans(null, true) }}</p>
                                </div>
                            </div>
                            <button class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                <span class="material-symbols-rounded text-[18px]">more_horiz</span>
                            </button>
                        </div>

                        {{-- Category badge --}}
                        <span class="badge-study text-[11px] mb-2 inline-flex">
                            {{ $note->category ? $note->category->icon . ' ' . $note->category->name : '📄 General' }}
                        </span>

                        {{-- Note title and excerpt --}}
                        <a href="{{ route('notes.show', $note->slug) }}" class="block">
                            <h3 class="text-[17px] font-bold text-slate-900 dark:text-white mb-1.5 leading-snug group-hover:text-sn-600 dark:group-hover:text-sn-300 transition-colors">
                                {{ $note->title }}
                            </h3>
                            <p class="text-[14px] text-slate-500 leading-relaxed line-clamp-2">
                                {!! strip_tags($note->content) !!}
                            </p>
                        </a>
                    </div>

                    {{-- Action bar --}}
                    <div class="px-5 pb-3 flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
                        <button class="feed-action-btn">
                            <span class="material-symbols-rounded text-[18px]">chat_bubble_outline</span>
                            {{ number_format($note->comments_count) }}
                        </button>
                        <button class="feed-action-btn hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20">
                            <span class="material-symbols-rounded text-[18px]">repeat</span>
                            0
                        </button>
                        <button class="feed-action-btn hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <span class="material-symbols-rounded text-[18px]">favorite_border</span>
                            {{ number_format($note->likes_count) }}
                        </button>
                        <button class="feed-action-btn hover:text-sn-600">
                            <span class="material-symbols-rounded text-[18px]">bar_chart</span>
                            {{ number_format($note->views_count) }}
                        </button>
                        <div class="flex items-center gap-1">
                            <button class="feed-action-btn">
                                <span class="material-symbols-rounded text-[18px]">bookmark_border</span>
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="card-p text-center py-12">
                    <span class="material-symbols-rounded text-[48px] text-slate-300">feed</span>
                    <p class="text-slate-500 mt-2">No notes in this feed yet.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notes->links() }}
            </div>
        </div>
    </div>

    {{-- ── RIGHT SIDEBAR ─────────────────────────────────────── --}}
    <aside class="hidden lg:flex flex-col gap-4 w-[320px] flex-shrink-0">

        {{-- Quick Stats --}}
        <div class="card-p">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=BBD5DA&color=1A3A3E&size=64' }}"
                     class="avatar-lg">
                <div>
                    <p class="font-semibold text-slate-900 dark:text-white text-[15px]">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-slate-400">@{{ auth()->user()->username }}</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3 text-center" x-data="{ 
                followingCount: {{ auth()->user()->following()->count() }},
                followersCount: {{ auth()->user()->followers()->count() }}
            }" @follow-updated.window="if ($event.detail.userId === {{ auth()->id() }}) followersCount = $event.detail.followersCount; if ($event.detail.isFollowing !== undefined) { /* update following count if needed */ }">
                <a href="{{ route('notes.index') }}" class="hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl p-2 transition-colors">
                    <p class="text-lg font-bold text-slate-900 dark:text-white">{{ auth()->user()->notes()->count() }}</p>
                    <p class="text-[11px] text-slate-400 font-medium">Notes</p>
                </a>
                <div class="hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl p-2 transition-colors cursor-pointer">
                    <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="followersCount">{{ auth()->user()->followers()->count() }}</p>
                    <p class="text-[11px] text-slate-400 font-medium">Followers</p>
                </div>
                <div class="hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl p-2 transition-colors cursor-pointer">
                    <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="$store.followStore.following.length">{{ auth()->user()->following()->count() }}</p>
                    <p class="text-[11px] text-slate-400 font-medium">Following</p>
                </div>
            </div>
        </div>

        {{-- Trending Topics --}}
        <div class="card-p">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[15px] text-slate-900 dark:text-white">Trending Subjects</h3>
            </div>
            <div class="space-y-3">
                @foreach($trendingCategories as $category)
                <div class="flex items-start justify-between cursor-pointer group">
                    <div>
                        <p class="text-[14px] font-semibold text-slate-900 dark:text-white group-hover:text-sn-600 dark:group-hover:text-sn-300 transition-colors">{{ $category->icon }} {{ $category->name }}</p>
                        <p class="text-[12px] text-slate-400">Popular subject</p>
                    </div>
                    <span class="material-symbols-rounded text-[16px] text-slate-300 group-hover:text-sn-400 mt-1 transition-colors">trending_up</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Who to Follow --}}
        <div class="card-p">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[15px] text-slate-900 dark:text-white">Who to Follow</h3>
            </div>
            <div class="space-y-4">
                @foreach($suggestedUsers as $suggested)
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.show', $suggested->username) }}">
                        <img src="{{ $suggested->profile_picture ? Storage::url($suggested->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($suggested->name).'&background=DFF1F1&color=1A3A3E&size=64' }}"
                             class="avatar-sm flex-shrink-0">
                    </a>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('profile.show', $suggested->username) }}" class="text-[14px] font-semibold text-slate-900 dark:text-white truncate leading-tight hover:underline block">
                            {{ $suggested->name }}
                        </a>
                        <p class="text-[12px] text-slate-400 truncate">{{ '@' . $suggested->username }}</p>
                    </div>
                    <x-follow-button :userId="$suggested->id" />
                </div>
                @endforeach
            </div>
        </div>

        {{-- Footer links --}}
        <div class="text-[11px] text-slate-400 leading-relaxed px-1">
            <div class="flex flex-wrap gap-x-3 gap-y-1 mb-1">
                <a href="#" class="hover:underline">Terms</a>
                <a href="#" class="hover:underline">Privacy</a>
                <a href="#" class="hover:underline">Cookies</a>
                <a href="#" class="hover:underline">Help</a>
            </div>
            <p>&copy; {{ date('Y') }} ShareNote, Inc.</p>
        </div>
    </aside>

</div>
@endsection
