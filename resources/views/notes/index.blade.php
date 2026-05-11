@extends('layouts.app')
@section('title', 'My Notes')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">My Notes</h1>
            <p class="page-subtitle">All notes you've published or drafted.</p>
        </div>
        <a href="{{ route('notes.create') }}" class="btn-primary text-sm">
            <span class="material-symbols-rounded text-[18px]">add</span>
            New Note
        </a>
    </div>

    {{-- Filter tabs --}}
    <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800 rounded-xl p-1 mb-6 w-fit">
        <button class="px-4 py-1.5 text-sm font-semibold bg-white dark:bg-slate-700 text-slate-900 dark:text-white rounded-lg shadow-sm">All</button>
        <button class="px-4 py-1.5 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 rounded-lg transition-colors">Public</button>
        <button class="px-4 py-1.5 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 rounded-lg transition-colors">Private</button>
        <button class="px-4 py-1.5 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 rounded-lg transition-colors">Drafts</button>
    </div>

    {{-- Notes grid --}}
    @if($notes->count())
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($notes as $note)
                <article class="card-hover p-5 group flex flex-col">
                    {{-- Category badge --}}
                    <div class="flex items-center justify-between mb-3">
                        <span class="badge-study text-[11px]">
                            {{ $note->category ? $note->category->icon . ' ' . $note->category->name : '📄 General' }}
                        </span>
                        <span class="text-[12px] text-slate-400">{{ $note->created_at->format('M d, Y') }}</span>
                    </div>

                    <h3 class="text-[16px] font-bold text-slate-900 dark:text-white group-hover:text-[#5C919A] dark:group-hover:text-[#9FBFC5] transition-colors mb-2 leading-snug flex-1">
                        {{ $note->title }}
                    </h3>

                    @if($note->content)
                        <p class="text-[13px] text-slate-500 leading-relaxed line-clamp-2 mb-4">
                            {!! strip_tags($note->content) !!}
                        </p>
                    @endif

                    {{-- Stats --}}
                    <div class="flex items-center gap-3 text-[12px] text-slate-400 mb-4">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-rounded text-[14px]">visibility</span>
                            {{ number_format($note->views_count) }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-rounded text-[14px]">favorite</span>
                            {{ number_format($note->likes_count) }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-rounded text-[14px]">bookmark</span>
                            {{ number_format($note->saves_count) }}
                        </span>
                        <span class="ml-auto inline-flex items-center gap-1 text-[11px] font-medium
                            {{ $note->visibility === 'public' ? 'text-emerald-500' : ($note->visibility === 'private' ? 'text-red-400' : 'text-amber-500') }}">
                            <span class="material-symbols-rounded text-[13px]">
                                {{ $note->visibility === 'public' ? 'public' : ($note->visibility === 'private' ? 'lock' : 'group') }}
                            </span>
                            {{ ucfirst($note->visibility) }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ route('notes.show', $note) }}"
                           class="flex-1 text-center text-[13px] font-medium text-[#5C919A] hover:text-[#1A3A3E] hover:bg-[#DFF1F1] rounded-lg py-1.5 transition-colors">
                            View
                        </a>
                        <a href="{{ route('notes.edit', $note) }}"
                           class="flex-1 text-center text-[13px] font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg py-1.5 transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST"
                              onsubmit="return confirm('Delete this note permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-[13px] font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg px-3 py-1.5 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $notes->links() }}
        </div>

    @else
        {{-- Empty State --}}
        <div class="card-p text-center py-16">
            <div class="w-16 h-16 bg-[#DFF1F1] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-rounded text-[32px] text-[#5C919A]">edit_note</span>
            </div>
            <h3 class="text-[17px] font-bold text-slate-900 dark:text-white mb-2">No notes yet</h3>
            <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
                Start sharing your knowledge with the community. Your first note could help hundreds of students!
            </p>
            <a href="{{ route('notes.create') }}" class="btn-primary text-sm">
                <span class="material-symbols-rounded text-[18px]">add</span>
                Create your first note
            </a>
        </div>
    @endif

</div>
@endsection
