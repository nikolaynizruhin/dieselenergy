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
                <div class="form-group row">
                    <label for="inputTitle" class="col-md-3 col-form-label">{{ __('common.title') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputTitle" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}" required autocomplete="title" autofocus>

                        @error('title')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Slug -->
                <div class="form-group row">
                    <label for="inputSlug" class="col-md-3 col-form-label">{{ __('common.slug') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputSlug" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $post->slug) }}" required autocomplete="slug">

                        @error('slug')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ __('image.title') }}</label>
                    <div class="col-md-6">
                        <img src="{{ asset('storage/'.$post->image->path) }}" class="img-fluid img-thumbnail mb-3" alt="Responsive image">
                        <div class="custom-file">
                            <input type="file" id="inputImage" class="custom-file-input @error('image') is-invalid @enderror" name="image" accept="image/*">
                            <label class="custom-file-label" for="inputImage">{{ __('common.choose_images') }}</label>

                            @error('image')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="form-group row">
                    <label for="inputExcerpt" class="col-md-3 col-form-label">{{ __('post.excerpt') }}</label>
                    <div class="col-md-6">
                        <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" id="inputExcerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>

                        @error('excerpt')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Body -->
                <div class="form-group row">
                    <label for="inputBody" class="col-md-3 col-form-label">
                        {{ __('post.body') }}
                        <small id="bodyHelpBlock" class="form-text text-muted">
                            {{ __('common.support') }} <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank"><u>Markdown</u></a>
                        </small>
                    </label>
                    <div class="col-md-6">
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="inputBody" rows="10" aria-describedby="bodyHelpBlock">{{ old('body', $post->body) }}</textarea>

                        @error('body')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
