@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex" role="alert">
        <div>
            @include('layouts.partials.icon', ['name' => 'check-circle-fill', 'classes' => 'me-3 text-teal', 'width' => '1.1em', 'height' => '1.1em'])
        </div>
        <div>
            {{ session('status') }}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
