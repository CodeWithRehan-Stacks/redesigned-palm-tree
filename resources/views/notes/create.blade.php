@extends('layouts.app')
@section('title', 'Create Note')

@push('head')
<script src="https://unpkg.com/@tiptap/standalone@latest"></script>
<style>
    .tiptap-editor {
        min-height: 400px;
        padding: 40px;
        outline: none;
    }
    .tiptap-editor h1 { font-size: 2em; font-weight: bold; margin-bottom: 0.5em; }
    .tiptap-editor h2 { font-size: 1.5em; font-weight: bold; margin-bottom: 0.5em; }
    .tiptap-editor p { margin-bottom: 1em; line-height: 1.6; }
    .tiptap-editor ul { list-style-type: disc; margin-left: 1.5em; margin-bottom: 1em; }
    .tiptap-editor ol { list-style-type: decimal; margin-left: 1.5em; margin-bottom: 1em; }
    .tiptap-toolbar {
        position: sticky;
        top: 70px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid #e2e8f0;
        padding: 8px;
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    .dark .tiptap-toolbar { background: rgba(15, 23, 42, 0.8); border-color: #334155; }
    .tiptap-btn {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 13px;
        color: #64748b;
        transition: all 0.15s;
    }
    .tiptap-btn:hover { background: #f1f5f9; color: #0f172a; }
    .dark .tiptap-btn:hover { background: #1e293b; color: #f1f5f9; }
    .tiptap-btn.is-active { background: #e2e8f0; color: #0f172a; font-weight: 600; }
    .dark .tiptap-btn.is-active { background: #334155; color: #f1f5f9; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Form with Auto-save indicator --}}
    <div x-data="noteEditor()" x-init="initEditor()" class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">New Note</h1>
                <span x-show="isSaving" class="text-xs text-slate-400 flex items-center gap-1">
                    <span class="material-symbols-rounded text-[14px] animate-spin">sync</span>
                    Saving...
                </span>
                <span x-show="!isSaving && lastSaved" class="text-xs text-emerald-500 flex items-center gap-1">
                    <span class="material-symbols-rounded text-[14px]">check_circle</span>
                    Saved to drafts
                </span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" @click="saveDraft()" class="btn-secondary text-sm">Save Draft</button>
                <button type="button" @click="publish()" class="btn-primary text-sm px-6">Publish</button>
            </div>
        </div>

        <form id="note-form" action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="content" x-model="content">
            
            <div class="space-y-6">
                {{-- Title --}}
                <input type="text" name="title" x-model="title" 
                       class="w-full bg-transparent border-none focus:ring-0 text-4xl font-extrabold text-slate-900 dark:text-white placeholder:text-slate-200 dark:placeholder:text-slate-800"
                       placeholder="Untitled Note">

                {{-- Meta Info Grid --}}
                <div class="grid sm:grid-cols-3 gap-4 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Category</label>
                        <select name="category_id" x-model="categoryId" class="w-full bg-transparent border-none p-0 text-sm text-slate-700 dark:text-slate-300 focus:ring-0">
                            <option value="">Choose subject...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Visibility</label>
                        <select name="visibility" x-model="visibility" class="w-full bg-transparent border-none p-0 text-sm text-slate-700 dark:text-slate-300 focus:ring-0">
                            <option value="public">🌍 Public</option>
                            <option value="followers">👥 Followers</option>
                            <option value="private">🔒 Private</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Tags</label>
                        <input type="text" name="tags" x-model="tags" placeholder="biology, cells..." 
                               class="w-full bg-transparent border-none p-0 text-sm text-slate-700 dark:text-slate-300 focus:ring-0">
                    </div>
                </div>

                {{-- Tiptap Editor Container --}}
                <div class="bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm min-h-[600px]">
                    <div class="tiptap-toolbar">
                        <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }" class="tiptap-btn">B</button>
                        <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }" class="tiptap-btn">I</button>
                        <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }" class="tiptap-btn">H1</button>
                        <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" class="tiptap-btn">H2</button>
                        <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }" class="tiptap-btn">Bullet</button>
                        <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }" class="tiptap-btn">Number</button>
                        <button type="button" @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'is-active': editor.isActive('codeBlock') }" class="tiptap-btn">Code</button>
                    </div>
                    <div id="tiptap-editor" class="tiptap-editor"></div>
                </div>

                {{-- Attachments --}}
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-pointer hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-rounded text-[18px]">add_photo_alternate</span>
                        <span class="text-xs font-semibold">Add Images</span>
                        <input type="file" name="images[]" multiple class="hidden" accept="image/*">
                    </label>
                    <label class="flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-pointer hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-rounded text-[18px]">attach_file</span>
                        <span class="text-xs font-semibold">Attach PDF</span>
                        <input type="file" name="attachments[]" multiple class="hidden" accept=".pdf">
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function noteEditor() {
        return {
            editor: null,
            title: localStorage.getItem('note_draft_title') || '',
            content: '',
            categoryId: localStorage.getItem('note_draft_category') || '',
            visibility: localStorage.getItem('note_draft_visibility') || 'public',
            tags: localStorage.getItem('note_draft_tags') || '',
            isSaving: false,
            lastSaved: null,

            initEditor() {
                const draftContent = localStorage.getItem('note_draft_content') || '';
                
                this.editor = new window.tiptap.Editor({
                    element: document.querySelector('#tiptap-editor'),
                    extensions: [
                        window.tiptap.StarterKit,
                    ],
                    content: draftContent,
                    onUpdate: ({ editor }) => {
                        this.content = editor.getHTML();
                        this.autoSave();
                    },
                });
            },

            autoSave() {
                this.isSaving = true;
                localStorage.setItem('note_draft_title', this.title);
                localStorage.setItem('note_draft_content', this.content);
                localStorage.setItem('note_draft_category', this.categoryId);
                localStorage.setItem('note_draft_visibility', this.visibility);
                localStorage.setItem('note_draft_tags', this.tags);
                
                setTimeout(() => {
                    this.isSaving = false;
                    this.lastSaved = new Date();
                }, 1000);
            },

            saveDraft() {
                this.autoSave();
                alert('Draft saved locally!');
            },

            publish() {
                this.content = this.editor.getHTML();
                if (!this.title) {
                    alert('Please enter a title');
                    return;
                }
                // Clear local storage after publish
                localStorage.removeItem('note_draft_title');
                localStorage.removeItem('note_draft_content');
                document.getElementById('note-form').submit();
            }
        }
    }
</script>
@endpush
@endsection
