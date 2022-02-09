@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('media.update') }}
        </div>

        <form action="{{ route('admin.medias.update', $media) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Product -->
                <div class="mb-3 row">
                    <label for="selectProduct" class="col-md-3 col-form-label">{{ __('product.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectProduct"
                                class="form-select @error('product_id') is-invalid @enderror"
                                name="product_id"
                                required>
                            <option value="{{ $media->product_id }}" selected>
                                {{ $media->product->name }}
                            </option>
                        </select>

                        @include('layouts.partials.error', ['name' => 'product_id'])
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3 row">
                    <label for="selectImage" class="col-md-3 col-form-label">{{ __('image.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectImage"
                                class="form-select @error('image_id') is-invalid @enderror"
                                name="image_id"
                                required>
                            <option value="{{ $media->image_id }}" selected>
                                {{ $media->image->name }}
                            </option>
                        </select>

                        @include('layouts.partials.error', ['name' => 'image_id'])
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3 row">
                    <div class="col-md-3">{{ __('common.status') }}</div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_default') is-invalid @enderror" value="1" name="is_default" id="inputDefault" @checked(old('is_default', $media->is_default))>
                            <label class="form-check-label" for="inputDefault">{{ __('common.default') }}</label>

                            @include('layouts.partials.error', ['name' => 'is_default'])
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
