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
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ __('common.images') }}</label>
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" multiple id="inputImages" class="custom-file-input @error('images.*') is-invalid @enderror" name="images[]" accept="image/*">
                            <label class="custom-file-label" for="inputImages">Choose images</label>

                            @error('images.*')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
