@extends('layouts.app')
@section('title', 'Create Note')

@push('head')
<script src="https://unpkg.com/@tiptap/standalone@latest"></script>

<style>
    .editor-shell {
        position: relative;
        overflow: hidden;
        border-radius: 2rem;
        border: 1px solid rgba(226,232,240,.8);
        background: rgba(255,255,255,.82);
        backdrop-filter: blur(18px);
        box-shadow: 0 20px 60px rgba(0,0,0,.06);
    }

    .dark .editor-shell {
        border-color: rgba(30,41,59,.9);
        background: rgba(13,17,23,.82);
    }

    .editor-glow {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .editor-glow::before {
        content: "";
        position: absolute;
        top: -80px;
        right: -80px;
        width: 240px;
        height: 240px;
        background: rgba(92,145,154,.18);
        border-radius: 999px;
        filter: blur(70px);
    }

    .tiptap-toolbar {
        position: sticky;
        top: 72px;
        z-index: 30;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 14px;
        border-bottom: 1px solid #e2e8f0;
        background: rgba(255,255,255,.75);
        backdrop-filter: blur(16px);
    }

    .dark .tiptap-toolbar {
        background: rgba(15,23,42,.7);
        border-color: #1e293b;
    }

    .tiptap-btn {
        height: 40px;
        min-width: 40px;
        padding: 0 14px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        transition: all .2s ease;
        background: transparent;
    }

    .tiptap-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
        transform: translateY(-1px);
    }

    .dark .tiptap-btn:hover {
        background: #1e293b;
        color: #f8fafc;
    }

    .tiptap-btn.is-active {
        background: linear-gradient(to right, #5C919A, #6EA2AA);
        color: white;
        box-shadow: 0 8px 25px rgba(92,145,154,.25);
    }

    .tiptap-editor {
        min-height: 600px;
        padding: 48px;
        outline: none;
        color: #0f172a;
        font-size: 16px;
        line-height: 1.9;
    }

    .dark .tiptap-editor {
        color: #f8fafc;
    }

    .tiptap-editor h1 {
        font-size: 2.5rem;
        line-height: 1.15;
        font-weight: 900;
        margin: 1.5rem 0 1rem;
    }

    .tiptap-editor h2 {
        font-size: 1.8rem;
        line-height: 1.2;
        font-weight: 800;
        margin: 1.4rem 0 1rem;
    }

    .tiptap-editor p {
        margin-bottom: 1.2rem;
    }

    .tiptap-editor ul,
    .tiptap-editor ol {
        padding-left: 1.5rem;
        margin-bottom: 1.2rem;
    }

    .tiptap-editor ul {
        list-style: disc;
    }

    .tiptap-editor ol {
        list-style: decimal;
    }

    .tiptap-editor blockquote {
        border-left: 4px solid #5C919A;
        padding-left: 1rem;
        color: #64748b;
        margin: 1.5rem 0;
        font-style: italic;
    }

    .tiptap-editor pre {
        background: #0f172a;
        color: #f8fafc;
        border-radius: 1rem;
        padding: 1rem;
        overflow-x: auto;
        margin: 1.5rem 0;
    }

    .dark .tiptap-editor pre {
        background: #020617;
    }

    .meta-card {
        border-radius: 1.5rem;
        border: 1px solid rgba(226,232,240,.8);
        background: rgba(248,250,252,.7);
        backdrop-filter: blur(10px);
    }

    .dark .meta-card {
        border-color: rgba(30,41,59,.9);
        background: rgba(15,23,42,.65);
    }

    .floating-btn {
        transition: all .25s ease;
    }

    .floating-btn:hover {
        transform: translateY(-2px) scale(1.02);
    }
</style>
@endpush

@section('content')

<div class="max-w-5xl mx-auto">

    <div x-data="noteEditor()" x-init="initEditor()" class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="space-y-2">

                <div class="flex items-center gap-3 flex-wrap">

                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                        Create Note
                    </h1>

                    <span x-show="isSaving"
                          class="inline-flex items-center gap-1 rounded-full bg-amber-100 text-amber-700 px-3 py-1 text-xs font-semibold dark:bg-amber-900/20 dark:text-amber-300">

                        <span class="material-symbols-rounded text-[14px] animate-spin">
                            sync
                        </span>

                        Saving...

                    </span>

                    <span x-show="!isSaving && lastSaved"
                          class="inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-xs font-semibold dark:bg-emerald-900/20 dark:text-emerald-300">

                        <span class="material-symbols-rounded text-[14px]">
                            check_circle
                        </span>

                        Draft saved

                    </span>

                </div>

                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Write beautifully formatted notes with a distraction-free editor.
                </p>

            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">

                <button type="button"
                        @click="saveDraft()"
                        class="floating-btn inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-white/5 px-5 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:shadow-lg">

                    <span class="material-symbols-rounded text-[18px]">
                        draft
                    </span>

                    Save Draft

                </button>

                <button type="button"
                        @click="publish()"
                        class="floating-btn inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#5C919A] to-[#73A8B0] px-6 py-3 text-sm font-bold text-white shadow-xl shadow-[#5C919A]/25">

                    <span class="material-symbols-rounded text-[18px]">
                        publish
                    </span>

                    Publish

                </button>

            </div>

        </div>

        <form id="note-form"
              action="{{ route('notes.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            <input type="hidden" name="content" x-model="content">

            {{-- Errors --}}
            @if($errors->any())

                <div class="rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-200">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-rounded">
                            error
                        </span>

                        <div>

                            <p class="font-bold">
                                Please fix the following issues:
                            </p>

                            <ul class="mt-3 list-disc list-inside space-y-1">

                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif

            {{-- Title --}}
            <div class="space-y-3">

                <input
                    type="text"
                    name="title"
                    x-model="title"
                    placeholder="Untitled Note"
                    class="w-full bg-transparent border-none focus:ring-0 text-4xl sm:text-5xl font-black tracking-tight text-slate-900 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-700 px-1"
                >

                <div class="h-px bg-gradient-to-r from-[#5C919A]/50 via-slate-200 dark:via-slate-700 to-transparent"></div>

            </div>

            {{-- Meta --}}
            <div class="meta-card p-5">

                <div class="grid gap-5 sm:grid-cols-3">

                    {{-- Category --}}
                    <div>

                        <label class="text-[11px] font-bold uppercase tracking-[0.24em] text-slate-400 block mb-2">
                            Category
                        </label>

                        <select
                            name="category_id"
                            x-model="categoryId"
                            class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#111827] px-4 py-3 text-sm text-slate-700 dark:text-slate-200 focus:border-[#5C919A] focus:ring-[#5C919A]"
                        >

                            <option value="">Choose category...</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Visibility --}}
                    <div>

                        <label class="text-[11px] font-bold uppercase tracking-[0.24em] text-slate-400 block mb-2">
                            Visibility
                        </label>

                        <select
                            name="visibility"
                            x-model="visibility"
                            class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#111827] px-4 py-3 text-sm text-slate-700 dark:text-slate-200 focus:border-[#5C919A] focus:ring-[#5C919A]"
                        >

                            <option value="public">🌍 Public</option>
                            <option value="followers">👥 Followers</option>
                            <option value="private">🔒 Private</option>

                        </select>

                    </div>

                    {{-- Tags --}}
                    <div>

                        <label class="text-[11px] font-bold uppercase tracking-[0.24em] text-slate-400 block mb-2">
                            Tags
                        </label>

                        <input
                            type="text"
                            name="tags"
                            x-model="tags"
                            placeholder="biology, cells..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#111827] px-4 py-3 text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-400 focus:border-[#5C919A] focus:ring-[#5C919A]"
                        >

                    </div>

                </div>

            </div>

            {{-- Editor --}}
            <div class="editor-shell">

                <div class="editor-glow"></div>

                {{-- Toolbar --}}
                <div class="tiptap-toolbar">

                    <button type="button"
                            @click="editor.chain().focus().toggleBold().run()"
                            :class="{ 'is-active': editor.isActive('bold') }"
                            class="tiptap-btn">
                        B
                    </button>

                    <button type="button"
                            @click="editor.chain().focus().toggleItalic().run()"
                            :class="{ 'is-active': editor.isActive('italic') }"
                            class="tiptap-btn">
                        I
                    </button>

                    <button type="button"
                            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                            :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }"
                            class="tiptap-btn">
                        H1
                    </button>

                    <button type="button"
                            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                            :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }"
                            class="tiptap-btn">
                        H2
                    </button>

                    <button type="button"
                            @click="editor.chain().focus().toggleBulletList().run()"
                            :class="{ 'is-active': editor.isActive('bulletList') }"
                            class="tiptap-btn">
                        • List
                    </button>

                    <button type="button"
                            @click="editor.chain().focus().toggleOrderedList().run()"
                            :class="{ 'is-active': editor.isActive('orderedList') }"
                            class="tiptap-btn">
                        1. List
                    </button>

                    <button type="button"
                            @click="editor.chain().focus().toggleCodeBlock().run()"
                            :class="{ 'is-active': editor.isActive('codeBlock') }"
                            class="tiptap-btn">
                        {"</>"} 
                    </button>

                </div>

                {{-- Editor --}}
                <div id="tiptap-editor" class="tiptap-editor"></div>

            </div>

            {{-- Upload --}}
            <div class="flex flex-wrap items-center gap-4">

                <label class="floating-btn inline-flex items-center gap-3 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#111827] px-5 py-4 cursor-pointer hover:border-[#5C919A] hover:bg-[#5C919A]/5 transition-all duration-300">

                    <span class="material-symbols-rounded text-[22px] text-[#5C919A]">
                        upload_file
                    </span>

                    <div>

                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Upload Attachments
                        </p>

                        <p class="text-xs text-slate-400">
                            PDF, DOCX, PPT, Images
                        </p>

                    </div>

                    <input
                        type="file"
                        name="attachments[]"
                        multiple
                        class="hidden"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.png,.jpg,.jpeg"
                    >

                </label>

            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>
    function noteEditor() {
        return {
            editor: null,
            title: localStorage.getItem('note_draft_title') || @json(old('title', '')),
            content: localStorage.getItem('note_draft_content') || @json(old('content', '')),
            categoryId: localStorage.getItem('note_draft_category') || @json(old('category_id', '')),
            visibility: localStorage.getItem('note_draft_visibility') || @json(old('visibility', 'public')),
            tags: localStorage.getItem('note_draft_tags') || @json(old('tags', '')),
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
                }, 700);

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

                localStorage.removeItem('note_draft_title');
                localStorage.removeItem('note_draft_content');

                document.getElementById('note-form').submit();

            }
        }
    }
</script>
@endpush
@endsection