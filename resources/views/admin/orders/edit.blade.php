@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('order.update') }}
        </div>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <!-- Status -->
                <div class="mb-3 row">
                    <label for="selectStatus" class="col-md-3 col-form-label">{{ __('common.status') }}</label>
                    <div class="col-md-6">
                        <select id="selectStatus"
                                class="form-select @error('status') is-invalid @enderror"
                                name="status"
                                required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if (old('status', $order->$status) == $status) selected @endif>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        @include('layouts.partials.error', ['name' => 'status'])
                    </div>
                </div>

                <!-- Total -->
                <div class="mb-3 row">
                    <label for="inputTotal" class="col-md-3 col-form-label">{{ __('common.total') }}</label>
                    <div class="col-md-6">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="basic-addon">UAH</span>
                            <input type="number" min="0.00" step="0.01" id="inputTotal" class="form-control @error('total') is-invalid @enderror" aria-label="Total" aria-describedby="basic-addon" name="total" value="{{ old('total', $order->decimal_total) }}" required autocomplete="total">

                            @include('layouts.partials.error', ['name' => 'total'])
                        </div>
                    </div>
                </div>

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
                                <option value="{{ $customer->id }}" @if (old('customer_id', $order->customer_id) == $customer->id) selected @endif>
                                    {{ $customer->email }}
                                </option>
                            @endforeach
                        </select>

                        @include('layouts.partials.error', ['name' => 'customer_id'])
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-3 row">
                    <label for="inputNotes" class="col-md-3 col-form-label">{{ __('common.notes') }}</label>
                    <div class="col-md-6">
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes', $order->notes) }}</textarea>

                        @include('layouts.partials.error', ['name' => 'notes'])
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
