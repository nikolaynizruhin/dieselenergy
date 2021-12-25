<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\PostFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePost;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\Admin\PostFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(PostFilters $filters)
    {
        $posts = Post::filter($filters)
            ->latest()
            ->paginate(10)
            ->withQuerySTring();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create', ['post' => new Post]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StorePost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        Post::create($request->getAttributes());

        return redirect()
            ->route('admin.posts.index')
            ->with('status', __('post.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StorePost  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, Post $post)
    {
        $post->update($request->getAttributes());

        return redirect()
            ->route('admin.posts.index')
            ->with('status', __('post.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('status', __('post.deleted'));
    }
}
