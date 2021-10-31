@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.attributes.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.attributes.create') }}" role="button">{{ __('attribute.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @if ($attributes->isEmpty())
            @include('admin.layouts.partials.empty', [
                'body' => __('attribute.missing'),
                'link' => route('admin.attributes.create'),
                'button' => __('attribute.add'),
            ])
        @else
            @include('admin.attributes.partials.list')
        @endif
    </div>
@endsection
