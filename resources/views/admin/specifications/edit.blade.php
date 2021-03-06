@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('specification.update') }}
        </div>

        <form action="{{ route('admin.specifications.update', $specification) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Category -->
                <div class="mb-3 row">
                    <label for="selectCategory" class="col-md-3 col-form-label">{{ __('category.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectCategory"
                                class="form-select @error('category_id') is-invalid @enderror"
                                name="category_id"
                                required>
                            <option value="{{ $specification->category->id }}" selected>
                                {{ $specification->category->name }}
                            </option>
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Attribute -->
                <div class="mb-3 row">
                    <label for="selectAttribute" class="col-md-3 col-form-label">{{ __('attribute.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectAttribute"
                                class="form-select @error('attribute_id') is-invalid @enderror"
                                name="attribute_id"
                                required>
                            <option value="">{{ __('attribute.select') }}</option>
                            @foreach ($attributes as $attribute)
                                @unless ($specification->category->attributes->contains($attribute) && $specification->attribute_id != $attribute->id)
                                    <option value="{{ $attribute->id }}" @if (old('attribute_id', $specification->attribute_id) == $attribute->id) selected @endif>
                                        {{ $attribute->name }}
                                    </option>
                                @endunless
                            @endforeach
                        </select>

                        @error('attribute_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Featured -->
                <div class="mb-3 row">
                    <div class="col-md-3">{{ __('common.feature') }}</div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_featured') is-invalid @enderror" value="1" name="is_featured" id="inputFeatured" @if (old('is_featured', $specification->is_featured)) checked @endif>
                            <label class="form-check-label" for="inputFeatured">{{ __('common.is_featured') }}</label>

                            @error('is_active')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
