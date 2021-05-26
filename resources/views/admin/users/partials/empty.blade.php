<div class="card-body text-center text-muted">
    <p class="mb-3">
        @include('layouts.partials.icon', ['name' => 'person-plus', 'width' => '2.5em', 'height' => '2.5em'])
    </p>
    <p class="mb-3">
        {{ __('user.missing') }}
    </p>
    <a class="btn btn-outline-primary d-block d-md-inline-block" href="{{ route('admin.users.create') }}" role="button">
        {{ __('user.add') }}
    </a>
</div>
