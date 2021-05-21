@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('currency.add') }}
        </div>

        <form action="{{ route('admin.currencies.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="inputCode" class="col-md-3 col-form-label">{{ __('currency.code') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputCode" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>

                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputSymbol" class="col-md-3 col-form-label">{{ __('currency.symbol') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputSymbol" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol') }}" required autocomplete="symbol">

                        @error('symbol')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="inputRate" class="col-md-3 col-form-label">{{ __('currency.rate') }}</label>
                    <div class="col-md-6">
                        <input type="number" step="any" id="inputRate" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" required autocomplete="rate">

                        @error('rate')
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
