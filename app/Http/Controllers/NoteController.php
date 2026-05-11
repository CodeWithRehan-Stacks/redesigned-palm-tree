<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = auth()->user()->notes()->with(['category'])->latest()->paginate(12);
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        // Return view
        return view('notes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'content' => 'nullable|string',
            'visibility' => 'required|in:public,private,followers',
            'tags' => 'nullable|string', // comma separated tags
            'cover_image' => 'nullable|image|max:5120', // max 5MB
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt,png,jpg,jpeg|max:20480', // 20MB per file
        ]);

        DB::beginTransaction();
        
        try {
            // Handle Slug
            $slug = Str::slug($validated['title']) . '-' . uniqid();

            // Handle Cover Image
            $coverImagePath = null;
            if ($request->hasFile('cover_image')) {
                $coverImagePath = $request->file('cover_image')->store('notes/covers', 'public');
            }

            // Create Note
            $note = Note::create([
                'user_id' => auth()->id(),
                'category_id' => $validated['category_id'] ?? null,
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'] ?? null,
                'visibility' => $validated['visibility'],
                'cover_image' => $coverImagePath,
            ]);

            // Handle Tags
            if (!empty($validated['tags'])) {
                $tagNames = array_map('trim', explode(',', $validated['tags']));
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    if (empty($tagName)) continue;
                    $tag = Tag::firstOrCreate([
                        'slug' => Str::slug($tagName)
                    ], [
                        'name' => $tagName
                    ]);
                    $tagIds[] = $tag->id;
                }
                $note->tags()->sync($tagIds);
            }

            // Handle File Attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('notes/attachments', 'public');
                    $note->files()->create([
                        'file_path' => $path,
                        'file_type' => $file->getClientOriginalExtension(),
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('home')->with('success', 'Note created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create note: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $note->load(['user', 'category', 'tags', 'files', 'comments.user']);

        if ($note->visibility !== 'public' && auth()->id() !== $note->user_id) {
            if ($note->visibility === 'private' || ! auth()->user()->isFollowing($note->user)) {
                abort(403, 'This note is not available.');
            }
        }

        $note->increment('views_count');

        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        abort_unless(auth()->id() === $note->user_id, 403);

        $categories = Category::orderBy('name')->get();
        return view('notes.edit', compact('note', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        abort_unless(auth()->id() === $note->user_id, 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'content'     => 'nullable|string',
            'visibility'  => 'required|in:public,private,followers',
        ]);

        $note->update($validated);

        return redirect()->route('notes.show', $note)->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        abort_unless(auth()->id() === $note->user_id, 403);

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted.');
    }
}
