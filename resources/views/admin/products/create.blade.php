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
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ __('common.images') }}</label>
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" multiple id="inputImages" class="custom-file-input @error('images.*') is-invalid @enderror" name="images[]" accept="image/*">
                            <label class="custom-file-label" for="inputImages">{{ __('common.choose_images') }}</label>

                            @error('images.*')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div class="form-group row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Model -->
                <div class="form-group row">
                    <label for="inputModel" class="col-md-3 col-form-label">{{ __('product.model') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputModel" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model') }}" required autocomplete="model">

                        @error('model')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Slug -->
                <div class="form-group row">
                    <label for="inputSlug" class="col-md-3 col-form-label">{{ __('common.slug') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputSlug" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" required autocomplete="slug">

                        @error('slug')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group row">
                    <div class="col-md-3">{{ __('common.status') }}</div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" id="inputStatus" class="form-check-input @error('is_active') is-invalid @enderror" value="1" name="is_active" @if (old('is_active', true)) checked @endif>
                            <label class="form-check-label" for="inputStatus">
                                {{ __('common.active') }}
                            </label>

                            @error('is_active')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Brand -->
                <div class="form-group row">
                    <label for="inputBrand" class="col-md-3 col-form-label">{{ __('brand.title') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id" id="inputBrand" required>
                            <option value="">{{ __('brand.select') }}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if (old('brand_id') == $brand->id) selected @endif>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('brand_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Category -->
                <div class="form-group row">
                    <label for="inputCategory" class="col-md-3 col-form-label">{{ __('category.title') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="inputCategory" required>
                            <option value="{{ $category->id }}" selected>
                                {{ $category->name }}
                            </option>
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Price -->
                <div class="form-group row">
                    <label for="inputPrice" class="col-md-3 col-form-label">{{ __('common.price') }}</label>
                    <div class="col-md-6">
                        <input type="number" id="inputPrice" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" min="1" required autocomplete="price">

                        @error('price')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group row">
                    <label for="inputDescription" class="col-md-3 col-form-label">
                        {{ __('common.description') }}
                        <br>
                        <small class="text-muted">{{ __('common.support') }} Markdown</small>
                    </label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="3">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Attributes -->
                @foreach($category->attributes as $attribute)
                    <div class="form-group row">
                        <label for="inputAttribute{{ $attribute->id }}" class="col-md-3 col-form-label">{{ $attribute->field }}</label>
                        <div class="col-md-6">
                            <input type="text" id="inputAttribute{{ $attribute->id }}" class="form-control @error('attributes.'.$attribute->id) is-invalid @enderror" name="attributes[{{ $attribute->id }}]" value="{{ old('attributes.'.$attribute->id) }}">

                            @error('attributes.'.$attribute->id)
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
