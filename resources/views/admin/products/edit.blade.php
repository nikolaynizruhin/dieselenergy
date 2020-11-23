@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('product.update') }}
        </div>

        <form action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Images -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ __('common.images') }}</label>
                    <div class="col-md-6">
                        @if ($product->images->isNotEmpty())
                            @include('products.partials.carousel')
                            <br>
                        @endif

                        <div class="custom-file">
                            <input type="file" multiple id="inputImages" class="custom-file-input @error('images.*') is-invalid @enderror" name="images[]" accept="image/*" aria-describedby="imagesHelp">
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
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>

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
                        <input type="text" id="inputModel" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model', $product->model) }}" required autocomplete="model">

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
                        <input type="text" id="inputSlug" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $product->slug) }}" required autocomplete="slug">

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
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input @error('is_active') is-invalid @enderror" value="1" name="is_active" id="inputStatus" @if (old('is_active', $product->is_active)) checked @endif>
                            <label class="custom-control-label" for="inputStatus">{{ __('common.active') }}</label>

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
                                <option value="{{ $brand->id }}" @if (old('brand_id', $product->brand_id) == $brand->id) selected @endif>
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
                            <option value="{{ $product->category->id }}" selected>
                                {{ $product->category->name }}
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
                    <label for="inputPrice" class="col-md-3 col-form-label">
                        {{ __('common.price') }}
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon">{{ $product->brand->currency->code }}</span>
                            </div>
                            <input type="number" min="0.01" step="0.01" id="inputPrice" class="form-control rounded-right @error('price') is-invalid @enderror" aria-label="Price" aria-describedby="basic-addon" name="price" value="{{ old('price', $product->decimal_price) }}" required autocomplete="price">

                            @error('price')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group row">
                    <label for="inputDescription" class="col-md-3 col-form-label">
                        {{ __('common.description') }}
                        <small id="descriptionHelpBlock" class="form-text text-muted">
                            {{ __('common.support') }} <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank"><u>Markdown</u></a>
                        </small>
                    </label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="10" aria-describedby="descriptionHelpBlock">{{ old('description', $product->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Attributes -->
                @foreach($product->category->attributes as $attribute)
                    <div class="form-group row">
                        <label for="inputAttribute{{ $attribute->id }}" class="col-md-3 col-form-label">{{ $attribute->field }}</label>
                        <div class="col-md-6">
                            <input type="text" id="inputAttribute{{ $attribute->id }}" class="form-control @error('attributes.'.$attribute->id) is-invalid @enderror" name="attributes[{{ $attribute->id }}]" value="{{ old('attributes.'.$attribute->id, $attribute->products->isEmpty() ? '' : $attribute->products->first()->pivot->value) }}">

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
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
