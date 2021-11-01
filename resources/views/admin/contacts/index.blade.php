@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admin.layouts.partials.search', ['url' => route('admin.contacts.index')])
        </div>
        <div class="col text-end">
            <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.contacts.create') }}" role="button">{{ __('contact.add') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        @includeWhen($contacts->isNotEmpty(), 'admin.contacts.partials.list', [
            'route' => [
                'name' => 'admin.contacts.index',
                'parameters' => []
            ],
        ])

        @includeWhen($contacts->isEmpty(), 'admin.layouts.partials.empty', [
            'body' => __('contact.missing'),
            'link' => route('admin.contacts.create'),
            'button' => __('contact.add'),
        ])
    </div>
@endsection
