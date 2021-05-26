@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('attribute.add') }}
        </div>

        <form action="{{ route('admin.attributes.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputMeasure" class="col-md-3 col-form-label">{{ __('common.measure') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputMeasure" class="form-control @error('measure') is-invalid @enderror" name="measure" value="{{ old('measure') }}" autocomplete="measure">

                        @error('measure')
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
