@extends('layouts.app')
@section('title', 'Search results for: ' . $query)

@section('content')
<div class="max-w-[720px] mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Search Results</h1>
        <p class="text-slate-500">Found results for "{{ $query }}"</p>
    </div>

    <div x-data="{ tab: 'notes' }">
        {{-- Search Tabs --}}
        <div class="flex border-b border-slate-200 dark:border-slate-800 mb-6">
            <button @click="tab = 'notes'" 
                    :class="tab === 'notes' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-400 border-transparent'"
                    class="px-6 py-3 text-sm font-semibold border-b-2 transition-all">
                Notes ({{ $notes->total() }})
            </button>
            <button @click="tab = 'people'" 
                    :class="tab === 'people' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white' : 'text-slate-400 border-transparent'"
                    class="px-6 py-3 text-sm font-semibold border-b-2 transition-all">
                People ({{ $users->count() }})
            </button>
        </div>

        {{-- Notes Results --}}
        <div x-show="tab === 'notes'">
            @include('profile.partials.notes_list', ['notes' => $notes, 'tab' => 'search'])
        </div>

        {{-- People Results --}}
        <div x-show="tab === 'people'" class="space-y-4">
            @forelse($users as $user)
                <div class="card-p flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('profile.show', $user->username) }}">
                            <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=DFF1F1&color=1A3A3E&size=64' }}"
                                 class="w-12 h-12 rounded-xl object-cover">
                        </a>
                        <div>
                            <a href="{{ route('profile.show', $user->username) }}" class="font-bold text-slate-900 dark:text-white hover:underline">
                                {{ $user->name }}
                            </a>
                            <p class="text-sm text-slate-400">{{ '@' . $user->username }} · {{ number_format($user->followers_count) }} followers</p>
                        </div>
                    </div>
                    @auth
                        @if(auth()->id() !== $user->id)
                            <x-follow-button :userId="$user->id" />
                        @endif
                    @endauth
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-slate-500">No people found matching your search.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
