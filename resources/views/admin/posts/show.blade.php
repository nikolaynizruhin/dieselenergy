@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('post.details') }}
            <a class="float-end" href="{{ route('admin.posts.edit', $post) }}" role="button">
                @include('layouts.partials.icon', ['name' => 'pencil', 'width' => '1em', 'height' => '1em'])
            </a>
        </div>


        <div class="card-body">

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('image.title') }}</div>
                <div class="col-md-9">
                    <img src="{{ asset('storage/'.$post->image->path) }}" class="img-fluid img-thumbnail mb-3" alt="{{ $post->title }}">
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.title') }}</div>
                <div class="col-md-9">
                    {{ $post->title }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.slug') }}</div>
                <div class="col-md-9">{{ $post->slug }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('post.excerpt') }}</div>
                <div class="col-md-9">{{ $post->excerpt }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('common.date') }}</div>
                <div class="col-md-9">{{ $post->created_at->format('Y-m-d H:i') }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('post.body') }}</div>
                <div class="col-md-9">@markdown($post->body)</div>
            </div>
        </div>
    </div>
@endsection
