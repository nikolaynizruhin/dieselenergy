<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\PostFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePost;
use App\Http\Requests\Admin\UpdatePost;
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
        $posts = Post::filter($filters)->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
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
            ->with('status', trans('post.created'));
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
     * @param  \App\Http\Requests\Admin\UpdatePost  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePost $request, Post $post)
    {
        $post->update($request->getAttributes());

        return redirect()
            ->route('admin.posts.index')
            ->with('status', trans('post.updated'));
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

        return back()->with('status', trans('post.deleted'));
    }
}
