@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Update Product') }}
        </div>

        <form action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Images -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ __('Images') }}</label>
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" multiple id="inputImages" class="custom-file-input @error('images.*') is-invalid @enderror" name="images[]" accept="image/*" aria-describedby="imagesHelp">
                            <label class="custom-file-label" for="inputImages">Choose images</label>
                            <small id="imagesHelp" class="form-text text-muted">The product already has {{ $product->images()->count() }} images.</small>

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
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group row">
                    <div class="col-md-3">{{ __('Status') }}</div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" id="inputStatus" class="form-check-input @error('is_active') is-invalid @enderror" value="1" name="is_active" @if (old('is_active', $product->is_active)) checked @endif>
                            <label class="form-check-label" for="inputStatus">
                                {{ __('Active') }}
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
                    <label for="inputBrand" class="col-md-3 col-form-label">{{ __('Brand') }}</label>
                    <div class="col-md-6">
                        <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id" id="inputBrand" required>
                            <option value="">Select a brand</option>
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
                    <label for="inputCategory" class="col-md-3 col-form-label">{{ __('Category') }}</label>
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
                    <label for="inputPrice" class="col-md-3 col-form-label">{{ __('Price') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon">$</span>
                            </div>
                            <input type="number" id="inputPrice" class="form-control rounded-right @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" name="price" min="1" aria-label="Price" aria-describedby="addon" required>

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
                        {{ __('Description') }}
                        <br>
                        <small class="text-muted">Supports Markdown</small>
                    </label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="3">{{ old('description', $product->description) }}</textarea>

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
                        <label for="inputAttribute{{ $attribute->id }}" class="col-md-3 col-form-label">{{ $attribute->name }}</label>
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
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
@endsection