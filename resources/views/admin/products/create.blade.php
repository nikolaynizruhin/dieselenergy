@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('product.add') }}
        </div>

        <form action="{{ route('admin.products.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-body">

                <!-- Images -->
                <div class="mb-3 row">
                    <label class="col-md-3 col-form-label" for="inputImages">{{ __('common.images') }}</label>
                    <div class="col-md-6">
                        <input type="file" multiple id="inputImages" class="form-control @error('images.*') is-invalid @enderror" name="images[]" accept="image/*">

                        @include('layouts.partials.error', ['name' => 'images.*'])
                    </div>
                </div>

                <!-- Name -->
                <div class="mb-3 row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @include('layouts.partials.error', ['name' => 'name'])
                    </div>
                </div>

                <!-- Model -->
                <div class="mb-3 row">
                    <label for="inputModel" class="col-md-3 col-form-label">{{ __('product.model') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputModel" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model') }}" required autocomplete="model">

                        @include('layouts.partials.error', ['name' => 'model'])
                    </div>
                </div>

                <!-- Slug -->
                <div class="mb-3 row">
                    <label for="inputSlug" class="col-md-3 col-form-label">{{ __('common.slug') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputSlug" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" required autocomplete="slug">

                        @include('layouts.partials.error', ['name' => 'slug'])
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3 row">
                    <div class="col-md-3">{{ __('common.status') }}</div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" value="1" name="is_active" id="inputStatus" @if (old('is_active', true)) checked @endif>
                            <label class="form-check-label" for="inputStatus">{{ __('common.active') }}</label>

                            @include('layouts.partials.error', ['name' => 'is_active'])
                        </div>
                    </div>
                </div>

                <!-- Brand -->
                <div class="mb-3 row">
                    <label for="inputBrand" class="col-md-3 col-form-label">{{ __('brand.title') }}</label>
                    <div class="col-md-6">
                        <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id" id="inputBrand" required>
                            <option value="">{{ __('brand.select') }}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if (old('brand_id') == $brand->id) selected @endif>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        @include('layouts.partials.error', ['name' => 'brand_id'])
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-3 row">
                    <label for="inputCategory" class="col-md-3 col-form-label">{{ __('category.title') }}</label>
                    <div class="col-md-6">
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="inputCategory" required>
                            <option value="{{ $category->id }}" selected>
                                {{ $category->name }}
                            </option>
                        </select>

                        @include('layouts.partials.error', ['name' => 'category_id'])
                    </div>
                </div>

                <!-- Price -->
                <div class="mb-3 row">
                    <label for="inputPrice" class="col-md-3 col-form-label">
                        {{ __('common.price') }}
                    </label>
                    <div class="col-md-6">
                        <input type="number" min="0.01" step="0.01" id="inputPrice" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price">

                        @include('layouts.partials.error', ['name' => 'price'])
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3 row">
                    <label for="inputDescription" class="col-md-3 col-form-label">
                        {{ __('common.description') }}
                        <div id="descriptionHelpBlock" class="form-text text-muted">
                            {{ __('common.support') }} <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Markdown</a>
                        </div>
                    </label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="10" aria-describedby="descriptionHelpBlock">{{ old('description') }}</textarea>

                        @include('layouts.partials.error', ['name' => 'description'])
                    </div>
                </div>

                <!-- Attributes -->
                @foreach($category->attributes as $attribute)
                    <div class="mb-3 row">
                        <label for="inputAttribute{{ $attribute->id }}" class="col-md-3 col-form-label">{{ $attribute->field }}</label>
                        <div class="col-md-6">
                            <input type="text" id="inputAttribute{{ $attribute->id }}" class="form-control @error('attributes.'.$attribute->id) is-invalid @enderror" name="attributes[{{ $attribute->id }}]" value="{{ old('attributes.'.$attribute->id) }}">

                            @include('layouts.partials.error', ['name' => 'attributes.'.$attribute->id])
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
