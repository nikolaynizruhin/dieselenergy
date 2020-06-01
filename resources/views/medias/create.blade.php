@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Add Media') }}
        </div>

        <form action="{{ route('medias.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <!-- Product -->
                <div class="form-group row">
                    <label for="selectProduct" class="col-md-3 col-form-label">{{ __('Product') }}</label>
                    <div class="col-md-6">
                        <select id="selectProduct"
                                class="form-control @error('product_id') is-invalid @enderror"
                                name="product_id"
                                required>
                            <option value="{{ $product->id }}" selected>
                                {{ $product->name }}
                            </option>
                        </select>

                        @error('product_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div class="form-group row">
                    <label for="selectImage" class="col-md-3 col-form-label">{{ __('Image') }}</label>
                    <div class="col-md-6">
                        <select id="selectImage"
                                class="form-control @error('image_id') is-invalid @enderror"
                                name="image_id"
                                required>
                            <option value="">Select an image...</option>
                            @foreach ($images as $image)
                                @unless ($product->images->contains($image))
                                    <option value="{{ $image->id }}" @if (old('image_id') == $image->id) selected @endif>
                                        {{ basename($image->path) }}
                                    </option>
                                @endunless
                            @endforeach
                        </select>

                        @error('image_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
            </div>
        </form>
    </div>
@endsection
