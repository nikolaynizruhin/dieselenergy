@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Add Specification') }}
        </div>

        <form action="{{ route('admin.specifications.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <!-- Category -->
                <div class="form-group row">
                    <label for="selectCategory" class="col-md-3 col-form-label">{{ __('Category') }}</label>
                    <div class="col-md-6">
                        <select id="selectCategory"
                                class="form-control @error('category_id') is-invalid @enderror"
                                name="category_id"
                                required>
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

                <!-- Attribute -->
                <div class="form-group row">
                    <label for="selectAttribute" class="col-md-3 col-form-label">{{ __('Attribute') }}</label>
                    <div class="col-md-6">
                        <select id="selectAttribute"
                                class="form-control @error('attribute_id') is-invalid @enderror"
                                name="attribute_id"
                                required>
                            <option value="">Select an attribute...</option>
                            @foreach ($attributes as $attribute)
                                @unless ($category->attributes->contains($attribute))
                                    <option value="{{ $attribute->id }}" @if (old('attribute_id') == $attribute->id) selected @endif>
                                        {{ $attribute->name }}
                                    </option>
                                @endunless
                            @endforeach
                        </select>

                        @error('attribute_id')
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
