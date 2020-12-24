@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.contacts.index')])
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.contacts.create') }}" role="button">{{ __('contact.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @include('admin.contacts.partials.'.($contacts->isEmpty() ? 'empty' : 'list'), [
            'route' => [
                'name' => 'admin.contacts.index',
                'params' => []
            ],
            'nested' => null,
        ])
    </div>
@endsection
