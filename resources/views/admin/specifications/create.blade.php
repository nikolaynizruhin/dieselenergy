@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 lead">
            {{ __('specification.add') }}
        </div>

        <form action="{{ route('admin.specifications.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <!-- Category -->
                <div class="mb-3 row">
                    <label for="selectCategory" class="col-md-3 col-form-label">{{ __('category.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectCategory"
                                class="form-select @error('category_id') is-invalid @enderror"
                                name="category_id"
                                required>
                            <option value="{{ $category->id }}" selected>
                                {{ $category->name }}
                            </option>
                        </select>

                        @include('layouts.partials.error', ['name' => 'category_id'])
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
                                @unless ($category->attributes->contains($attribute))
                                    <option value="{{ $attribute->id }}" @selected(old('attribute_id') == $attribute->id)>
                                        {{ $attribute->name }}
                                    </option>
                                @endunless
                            @endforeach
                        </select>

                        @include('layouts.partials.error', ['name' => 'attribute_id'])
                    </div>
                </div>

                <!-- Featured -->
                <div class="mb-3 row">
                    <div class="col-md-3">{{ __('common.feature') }}</div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_featured') is-invalid @enderror" value="1" name="is_featured" id="inputFeatured" @checked(old('is_featured'))>
                            <label class="form-check-label" for="inputFeatured">{{ __('common.is_featured') }}</label>

                            @include('layouts.partials.error', ['name' => 'is_active'])
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
