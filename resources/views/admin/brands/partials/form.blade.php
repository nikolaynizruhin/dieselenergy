<div class="card-body">

    <!-- Name -->
    <div class="mb-3 row">
        <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $brand) }}" required autocomplete="name" autofocus>

            @include('layouts.partials.error', ['name' => 'name'])
        </div>
    </div>

    <!-- Currency -->
    <div class="mb-3 row">
        <label for="inputCurrency" class="col-md-3 col-form-label">{{ __('currency.title') }}</label>
        <div class="col-md-6">
            <select class="form-select @error('currency_id') is-invalid @enderror" name="currency_id" id="inputCurrency" required>
                <option value="">{{ __('currency.select') }}</option>
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}" @selected(old('currency_id', $brand) == $currency->id)>
                        {{ $currency->code }}
                    </option>
                @endforeach
            </select>

            @include('layouts.partials.error', ['name' => 'currency_id'])
        </div>
    </div>
</div>

<div class="card-footer text-end border-0">
    <button type="submit" class="btn btn-primary text-white">{{ $button ?? __('common.create') }}</button>
</div>
