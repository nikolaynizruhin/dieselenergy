@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('attribute.update') }}
        </div>

        <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $attribute->name) }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputMeasure" class="col-md-3 col-form-label">{{ __('common.measure') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputMeasure" class="form-control @error('measure') is-invalid @enderror" name="measure" value="{{ old('measure', $attribute->measure) }}" autocomplete="measure">

                        @error('measure')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
