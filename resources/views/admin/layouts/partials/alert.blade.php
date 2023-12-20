@session('status')
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
        @include('layouts.partials.icon', ['name' => 'check-circle-fill', 'classes' => 'bi flex-shrink-0 me-3 text-teal', 'width' => '1.4em', 'height' => '1.4em'])
        <div>{{ session('status') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endsession
