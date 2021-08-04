<form action="{{ $url }}" method="GET">
    <div class="mb-3">
        <label for="search" class="visually-hidden">{{ __('common.search') }}</label>
        <input type="search" name="{{ $name ?? 'search' }}" class="form-control shadow-sm" value="{{ request($value ?? 'search') }}" onsearch="this.form.submit()" id="search" aria-describedby="search" placeholder="{{ __('common.search') }}">
    </div>
</form>
