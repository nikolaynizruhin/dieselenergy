<div class="card-body">

    <!-- Name -->
    <div class="mb-3 row">
        <label for="inputName" class="col-md-3 col-form-label">{{ __('customer.name') }}</label>
        <div class="col-md-6">
            <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $customer) }}" required autocomplete="name" autofocus>

            @include('layouts.partials.error', ['name' => 'name'])
        </div>
    </div>

    <!-- Email -->
    <div class="mb-3 row">
        <label for="inputEmail" class="col-md-3 col-form-label">{{ __('common.email') }}</label>
        <div class="col-md-6">
            <input type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $customer) }}" required autocomplete="email">

            @include('layouts.partials.error', ['name' => 'email'])
        </div>
    </div>

    <!-- Phone -->
    <div class="mb-3 row">
        <label for="inputPhone" class="col-md-3 col-form-label">{{ __('common.phone') }}</label>
        <div class="col-md-6">
            <input type="tel" id="inputPhone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $customer) }}" pattern="[+]{1}380[0-9]{9}" required autocomplete="phone">

            @include('layouts.partials.error', ['name' => 'phone'])
        </div>
    </div>

    <!-- Notes -->
    <div class="mb-3 row">
        <label for="inputNotes" class="col-md-3 col-form-label">{{ __('common.notes') }}</label>
        <div class="col-md-6">
            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes', $customer) }}</textarea>

            @include('layouts.partials.error', ['name' => 'notes'])
        </div>
    </div>
</div>

<div class="card-footer text-end border-0">
    <button type="submit" class="btn btn-primary text-white">{{ $button ?? __('common.create') }}</button>
</div>
