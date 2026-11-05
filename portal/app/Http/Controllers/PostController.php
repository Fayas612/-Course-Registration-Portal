<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('news.index', ['posts' => Post::published()->with('author')->latest('published_at')->paginate(9)]);
    }

    public function publicShow(Post $post)
    {
        abort_unless($post->is_published && $post->published_at?->lte(now()), 404);

        return view('news.show', compact('post'));
    }

    public function adminIndex()
    {
        return view('admin.posts.index', ['posts' => Post::with('author')->latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = (Str::slug($data['title']) ?: 'post').'-'.strtolower((string) Str::ulid());
        $data['published_at'] = $data['is_published'] ? now() : null;
        $post = new Post($data);
        $post->user_id = $request->user()->id;
        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Post saved successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request);
        $data['published_at'] = $data['is_published'] ? ($post->published_at ?? now()) : null;
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function confirmDelete(Post $post)
    {
        return view('admin.posts.delete', compact('post'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['required', 'string', 'max:300'],
            'body' => ['required', 'string', 'max:30000'],
            'is_published' => ['required', 'boolean'],
        ]);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
