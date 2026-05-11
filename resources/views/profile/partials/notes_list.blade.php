<div class="space-y-3" id="notes-container">
    @forelse($notes as $note)
        <article class="feed-card p-5 cursor-pointer group" onclick="window.location.href='{{ route('notes.show', $note->slug) }}'">
            <div class="flex items-center justify-between mb-2">
                <span class="badge-study text-[11px] inline-flex">
                    {{ $note->category ? $note->category->icon . ' ' . $note->category->name : '📄 General' }}
                </span>
                @if(isset($tab) && $tab !== 'notes')
                    <span class="text-[11px] text-slate-400">By {{ $note->user->name }}</span>
                @endif
            </div>
            
            <h3 class="text-[16px] font-bold text-slate-900 dark:text-white group-hover:text-sn-700 dark:group-hover:text-sn-300 transition-colors mb-1">
                {{ $note->title }}
            </h3>
            
            @if($note->content)
                <p class="text-[14px] text-slate-500 line-clamp-2 leading-relaxed mb-3">
                    {!! strip_tags($note->content) !!}
                </p>
            @endif
            
            <div class="flex items-center gap-4 text-[13px] text-slate-400">
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
                <span class="ml-auto">{{ $note->created_at->diffForHumans() }}</span>
            </div>
        </article>
    @empty
        <div class="card-p text-center py-12">
            <span class="material-symbols-rounded text-[48px] text-slate-300 dark:text-slate-600">article</span>
            <h3 class="text-[15px] font-semibold text-slate-900 dark:text-white mt-3">No notes here</h3>
            <p class="text-sm text-slate-400 mt-1">
                Nothing to show in this category yet.
            </p>
        </div>
    @endforelse
    
    <div class="mt-6">
        {{ $notes->links() }}
    </div>
</div>
