<div class="row">
    <div class="col-md-4">
        @include('admin.layouts.partials.search', ['url' => route('admin.customers.show', $customer), 'name' => 'search[contact]', 'value' => 'search.contact'])
    </div>
    <div class="col text-end">
        <a class="btn btn-primary text-white d-block d-md-inline-block shadow-sm mb-3" href="{{ route('admin.contacts.create', ['customer_id' => $customer->id]) }}" role="button">{{ __('contact.add') }}</a>
    </div>
</div>

<div class="card shadow-sm">
    @if ($contacts->isEmpty())
        @include('admin.layouts.partials.empty', [
            'body' => __('contact.missing'),
            'link' => route('admin.contacts.create'),
            'button' => __('contact.add'),
        ])
    @else
        @include('admin.contacts.partials.list', [
            'route' => [
                'name' => 'admin.customers.show',
                'parameters' => ['customer' => $customer]
            ],
            'nested' => 'contact'
        ])
    @endif
</div>
