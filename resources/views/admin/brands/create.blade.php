@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('brand.add') }}
        </div>

        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <!-- Name -->
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

                <!-- Currency -->
                <div class="mb-3 row">
                    <label for="inputCurrency" class="col-md-3 col-form-label">{{ __('currency.title') }}</label>
                    <div class="col-md-6">
                        <select class="form-select @error('currency_id') is-invalid @enderror" name="currency_id" id="inputCurrency" required>
                            <option value="">{{ __('currency.select') }}</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" @if (old('currency_id') == $currency->id) selected @endif>
                                    {{ $currency->code }}
                                </option>
                            @endforeach
                        </select>

                        @error('currency_id')
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
