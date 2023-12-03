<div class="card-body">
    <!-- Customer -->
    <div class="mb-3 row">
        <label for="selectCustomer" class="col-md-3 col-form-label">{{ __('customer.title') }}</label>
        <div class="col-md-6">
            <select id="selectCustomer"
                    class="form-select @error('customer_id') is-invalid @enderror"
                    name="customer_id"
                    required>
                <option value="">{{ __('customer.select') }}</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" @selected(old('customer_id', $contact ?? request('customer_id')) == $customer->id)>
                        {{ $customer->email }}
                    </option>
                @endforeach
            </select>

            @include('layouts.partials.error', ['name' => 'customer_id'])
        </div>
    </div>

    <!-- Message -->
    <div class="mb-3 row">
        <label for="inputMessage" class="col-md-3 col-form-label">{{ __('contact.message') }}</label>
        <div class="col-md-6">
            <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="inputMessage" rows="3">{{ old('message', $contact) }}</textarea>

            @include('layouts.partials.error', ['name' => 'message'])
        </div>
    </div>
</div>

<div class="card-footer text-end border-0">
    <button type="submit" class="btn btn-primary text-white">{{ $button ?? __('common.create') }}</button>
</div>
