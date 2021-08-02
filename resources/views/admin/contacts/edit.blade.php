@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('contact.update') }}
        </div>

        <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
            @csrf
            @method('PUT')
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
                                <option value="{{ $customer->id }}" @if (old('customer_id', $contact->customer_id) == $customer->id) selected @endif>
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
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="inputMessage" rows="3">{{ old('message', $contact->message) }}</textarea>

                        @include('layouts.partials.error', ['name' => 'message'])
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
