<div class="card-body d-flex flex-column align-items-center text-muted">
    @include('layouts.partials.icon', ['name' => 'cash-stack', 'classes' => 'mb-3', 'width' => '2.5em', 'height' => '2.5em'])
    {{ __('currency.missing') }}
    <a class="btn btn-outline-primary d-block d-md-inline-block mt-3" href="{{ route('admin.currencies.create') }}" role="button">
        {{ __('currency.add') }}
    </a>
</div>
