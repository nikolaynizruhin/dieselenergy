@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('image.add') }}
        </div>

        <form action="{{ route('admin.images.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-body">

                <!-- Images -->
                <div class="mb-3 row">
                    <label class="col-md-3 col-form-label" for="inputImages">{{ __('common.images') }}</label>
                    <div class="col-md-6">
                        <input type="file" multiple id="inputImages" class="form-control @error('images.*') is-invalid @enderror" name="images[]" accept="image/*">

                        @error('images.*')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
