@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.users.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.users.create') }}" role="button">{{ __('user.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @if ($users->isEmpty())
            @include('admin.layouts.partials.empty', [
                'icon' => 'person-plus',
                'body' => __('user.missing'),
                'link' => route('admin.users.create'),
                'button' => __('user.add'),
            ])
        @else
            @include('admin.users.partials.list')
        @endif
    </div>
@endsection
