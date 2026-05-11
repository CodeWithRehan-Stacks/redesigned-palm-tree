@extends('layouts.app')
@section('title', 'Edit Note')

@push('head')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">Edit Note</h1>
            <p class="page-subtitle">Update your note details and content.</p>
        </div>
        <a href="{{ route('notes.show', $note) }}" class="btn-ghost text-sm">
            <span class="material-symbols-rounded text-[18px]">close</span>
            Cancel
        </a>
    </div>

    @if($errors->any())
        <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 space-y-1">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('notes.update', $note) }}" method="POST" enctype="multipart/form-data" id="edit-form">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div class="card-p">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title', $note->title) }}" required class="input-field text-lg font-semibold">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Category</label>
                        <select name="category_id" class="input-field appearance-none cursor-pointer">
                            <option value="">No category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $note->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Visibility</label>
                        <select name="visibility" class="input-field appearance-none cursor-pointer">
                            <option value="public" {{ old('visibility', $note->visibility) === 'public' ? 'selected' : '' }}>🌍 Public</option>
                            <option value="followers" {{ old('visibility', $note->visibility) === 'followers' ? 'selected' : '' }}>👥 Followers only</option>
                            <option value="private" {{ old('visibility', $note->visibility) === 'private' ? 'selected' : '' }}>🔒 Private</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-p">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Content</label>
                <input type="hidden" name="content" id="content-hidden">
                <div class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
                    <div id="quill-editor" class="min-h-[280px] text-[15px]"></div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2">
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger text-sm py-2 px-5">
                        <span class="material-symbols-rounded text-[18px]">delete</span>
                        Delete Note
                    </button>
                </form>
                <button type="submit" class="btn-primary text-sm px-8" onclick="submitForm()">
                    <span class="material-symbols-rounded text-[18px]">save</span>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
<script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: { toolbar: [[{header:[1,2,3,false]}],['bold','italic','underline'],['blockquote','code-block'],[{list:'ordered'},{list:'bullet'}],['link'],['clean']] }
    });
    quill.root.innerHTML = {!! json_encode($note->content ?? '') !!};
    function submitForm() { document.getElementById('content-hidden').value = quill.root.innerHTML; }
</script>
<style>
.ql-toolbar{border-color:#e2e8f0!important;background:#f8fafc;}
.ql-container{border-color:#e2e8f0!important;font-size:15px!important;}
.ql-editor{min-height:280px;padding:16px 20px;}
</style>
@endpush
@endsection
