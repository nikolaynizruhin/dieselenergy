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
                <div class="form-group row">
                    <label for="selectProduct" class="col-md-3 col-form-label">{{ __('product.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectProduct"
                                class="form-control @error('product_id') is-invalid @enderror"
                                name="product_id"
                                required>
                            <option value="{{ $media->product_id }}" selected>
                                {{ $media->product->name }}
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
                    <label for="selectImage" class="col-md-3 col-form-label">{{ __('image.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectImage"
                                class="form-control @error('image_id') is-invalid @enderror"
                                name="image_id"
                                required>
                            <option value="{{ $media->image_id }}" selected>
                                {{ $media->image->name }}
                            </option>
                        </select>

                        @error('image_id')
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
                            <input type="checkbox" class="custom-control-input @error('is_default') is-invalid @enderror" value="1" name="is_default" id="inputDefault" @if (old('is_default', $media->is_default)) checked @endif>
                            <label class="custom-control-label" for="inputDefault">{{ __('common.default') }}</label>

                            @error('is_default')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
