@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('post.details') }}
        </div>


        <div class="card-body">
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
                <div class="col-md-3 text-muted">{{ __('common.date') }}</div>
                <div class="col-md-9">{{ $post->created_at }}</div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-3 text-muted">{{ __('post.body') }}</div>
                <div class="col-md-9">{{ $post->body }}</div>
            </div>
        </div>
    </div>
@endsection
