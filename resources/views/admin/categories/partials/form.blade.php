<div class="card-body">
    <!-- Name -->
    <div class="mb-3 row">
        <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}" required autocomplete="name" autofocus>

            @include('layouts.partials.error', ['name' => 'name'])
        </div>
    </div>

    <!-- Slug -->
    <div class="mb-3 row">
        <label for="inputSlug" class="col-md-3 col-form-label">{{ __('common.slug') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputSlug" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $category->slug) }}" required autocomplete="slug">

            @include('layouts.partials.error', ['name' => 'slug'])
        </div>
    </div>
</div>

<div class="card-footer bg-light text-end border-0">
    <button type="submit" class="btn btn-primary text-white">{{ $button ?? __('common.create') }}</button>
</div>
