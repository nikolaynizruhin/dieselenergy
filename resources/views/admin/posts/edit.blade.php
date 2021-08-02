@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('post.update') }}
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Title -->
                <div class="mb-3 row">
                    <label for="inputTitle" class="col-md-3 col-form-label">{{ __('common.title') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputTitle" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}" required autocomplete="title" autofocus>

                        @include('layouts.partials.error', ['name' => 'title'])
                    </div>
                </div>

                <!-- Slug -->
                <div class="mb-3 row">
                    <label for="inputSlug" class="col-md-3 col-form-label">{{ __('common.slug') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputSlug" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $post->slug) }}" required autocomplete="slug">

                        @include('layouts.partials.error', ['name' => 'slug'])
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3 row">
                    <label class="col-md-3 col-form-label" for="inputImage">{{ __('image.title') }}</label>
                    <div class="col-md-6">
                        <img src="{{ asset('storage/'.$post->image->path) }}" class="img-fluid img-thumbnail mb-3" alt="{{ $post->title }}" loading="lazy">

                        <input type="file" id="inputImage" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">

                        @include('layouts.partials.error', ['name' => 'image'])
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="mb-3 row">
                    <label for="inputExcerpt" class="col-md-3 col-form-label">{{ __('post.excerpt') }}</label>
                    <div class="col-md-6">
                        <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" id="inputExcerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>

                        @include('layouts.partials.error', ['name' => 'excerpt'])
                    </div>
                </div>

                <!-- Body -->
                <div class="mb-3 row">
                    <label for="inputBody" class="col-md-3 col-form-label">
                        {{ __('post.body') }}
                        <div id="bodyHelpBlock" class="form-text text-muted">
                            {{ __('common.support') }} <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Markdown</a>
                        </div>
                    </label>
                    <div class="col-md-6">
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="inputBody" rows="10" aria-describedby="bodyHelpBlock">{{ old('body', $post->body) }}</textarea>

                        @include('layouts.partials.error', ['name' => 'body'])
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
