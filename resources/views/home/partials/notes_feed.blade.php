@foreach($notes as $note)
    <article onclick="window.location.href='{{ route('notes.show', $note->slug) }}'" class="feed-card group overflow-hidden border-slate-200 shadow-sm hover:shadow-xl transition-shadow duration-300">
        <div class="p-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $note->user->profile_picture ? Storage::url($note->user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($note->user->name).'&background=DFF1F1&color=1A3A3E&size=64' }}" class="w-12 h-12 rounded-2xl object-cover">
                    <div>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $note->user->name }}</p>
                        <p class="text-xs text-slate-400">{{ '@' . $note->user->username }} · {{ $note->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <span class="badge-study">{{ $note->category ? $note->category->icon . ' ' . $note->category->name : '📄 General' }}</span>
            </div>

            <div class="space-y-3">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-sn-600 transition-colors">{{ $note->title }}</h3>
                @if($note->content)
                    <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">{!! strip_tags($note->content) !!}</p>
                @else
                    <p class="text-sm text-slate-500 leading-relaxed line-clamp-3">No content preview available.</p>
                @endif
            </div>
        </div>

        <div class="px-6 pb-5 pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
            <span class="flex items-center gap-2">
                <span class="material-symbols-rounded text-[18px]">visibility</span>
                {{ number_format($note->views_count) }}
            </span>
            <span class="flex items-center gap-2">
                <span class="material-symbols-rounded text-[18px]">favorite_border</span>
                {{ number_format($note->likes_count) }}
            </span>
            <span class="flex items-center gap-2">
                <span class="material-symbols-rounded text-[18px]">bookmark_border</span>
                {{ number_format($note->saves_count) }}
            </span>
            <span class="ml-auto text-slate-400">{{ number_format($note->comments_count) }} comments</span>
        </div>
    </article>
@endforeach

@if($notes->isEmpty())
    <div class="card-p text-center py-14">
        <span class="material-symbols-rounded text-[48px] text-slate-300">article</span>
        <h3 class="text-[18px] font-semibold text-slate-900 dark:text-white mt-4">No notes available</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Try exploring trending subjects or upload your first note.</p>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('notes.create') }}" class="btn-gradient">Upload your first note</a>
        </div>
    </div>
@endif
