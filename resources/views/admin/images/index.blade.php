@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.images.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.images.create') }}" role="button">{{ __('image.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @if ($images->isEmpty())
            @include('admin.layouts.partials.empty', [
                'body' => __('image.missing'),
                'link' => route('admin.images.create'),
                'button' => __('image.add'),
            ])
        @else
            @include('admin.images.partials.list')
        @endif
    </div>
@endsection
