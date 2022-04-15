<div class="card-body">
    <div class="mb-3 row">
        <label for="inputCode" class="col-md-3 col-form-label">{{ __('currency.code') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputCode" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $currency) }}" required autocomplete="code" autofocus>

            @include('layouts.partials.error', ['name' => 'code'])
        </div>
    </div>

    <div class="mb-3 row">
        <label for="inputSymbol" class="col-md-3 col-form-label">{{ __('currency.symbol') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputSymbol" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol', $currency) }}" required autocomplete="symbol">

            @include('layouts.partials.error', ['name' => 'symbol'])
        </div>
    </div>

    <div class="mb-3 row">
        <label for="inputRate" class="col-md-3 col-form-label">{{ __('currency.rate') }}</label>
        <div class="col-md-6">
            <input type="number" step="any" id="inputRate" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate', $currency) }}" required autocomplete="rate">

            @include('layouts.partials.error', ['name' => 'rate'])
        </div>
    </div>
</div>

<div class="card-footer bg-light text-end border-0">
    <button type="submit" class="btn btn-primary text-white">{{ $button ?? __('common.create') }}</button>
</div>
