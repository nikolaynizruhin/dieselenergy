<form action="{{ $url }}" method="GET">
    <div class="form-group">
        <label for="search" class="sr-only">{{ __('common.search') }}</label>
        <input type="search" name="search" class="form-control shadow-sm" value="{{ request('search') }}" id="search" aria-describedby="search" placeholder="{{ __('common.search') }}">
    </div>
</form>
