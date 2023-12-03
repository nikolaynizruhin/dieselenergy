<div class="card-body">
    <div class="mb-3 row">
        <label for="inputName" class="col-md-3 col-form-label">{{ __('common.name') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $attribute) }}" required autocomplete="name" autofocus>

            @include('layouts.partials.error', ['name' => 'name'])
        </div>
    </div>

    <div class="mb-3 row">
        <label for="inputMeasure" class="col-md-3 col-form-label">{{ __('common.measure') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputMeasure" class="form-control @error('measure') is-invalid @enderror" name="measure" value="{{ old('measure', $attribute) }}" autocomplete="measure">

            @include('layouts.partials.error', ['name' => 'measure'])
        </div>
    </div>
</div>

<div class="card-footer text-end border-0">
    <button type="submit" class="btn btn-primary text-white">{{ $button ?? __('common.create') }}</button>
</div>
