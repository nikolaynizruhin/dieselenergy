<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\PostFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePost;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PostFilters $filters): View
    {
        $posts = Post::query()
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQuerySTring();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.posts.create', ['post' => new Post]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request): RedirectResponse
    {
        Post::create($request->getAttributes());

        return to_route('admin.posts.index')
            ->with('status', __('post.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, Post $post): RedirectResponse
    {
        $post->update($request->getAttributes());

        return to_route('admin.posts.index')
            ->with('status', __('post.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('status', __('post.deleted'));
    }
}
