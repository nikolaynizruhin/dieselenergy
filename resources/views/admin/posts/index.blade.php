@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.posts.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.posts.create') }}" role="button">{{ __('post.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @includeWhen($posts->isNotEmpty(), 'admin.posts.partials.list')
        @includeWhen($posts->isEmpty(), 'admin.layouts.partials.empty', [
            'body' => __('post.missing'),
            'link' => route('admin.posts.create'),
            'button' => __('post.add'),
        ])
    </div>
@endsection
