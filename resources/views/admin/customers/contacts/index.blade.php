<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.customers.show', $customer), 'name' => 'search[contact]', 'value' => 'search.contact'])
    </div>
    <div class="col text-end">
        <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.contacts.create', ['customer_id' => $customer->id]) }}" role="button">{{ __('contact.add') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @include('admin.contacts.partials.'.($contacts->isEmpty() ? 'empty' : 'list'), [
        'route' => [
            'name' => 'admin.customers.show',
            'parameters' => ['customer' => $customer]
        ],
        'nested' => 'contact'
    ])
</div>
