<div class="card-body text-center text-muted">
    <p class="mb-3">
        @include('layouts.partials.icon', ['name' => $icon ?? 'file-earmark-plus', 'width' => '2.5em', 'height' => '2.5em'])
    </p>
    <p class="mb-3">
        {{ $body }}
    </p>
    <a class="btn btn-outline-primary d-block d-md-inline-block" href="{{ $link }}" role="button">
        {{ $button }}
    </a>
</div>
