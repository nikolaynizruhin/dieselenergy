<form action="{{ $url }}" method="GET">
    <div class="form-group">
        <label for="search" class="sr-only">{{ __('Search') }}</label>
        <input type="text" name="search" class="form-control shadow-sm" value="{{ request('search') }}" id="search" aria-describedby="search" placeholder="Search">
    </div>
</form>
