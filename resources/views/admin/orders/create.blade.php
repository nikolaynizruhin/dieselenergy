@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('order.add') }}
        </div>

        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
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
                                <option value="{{ $status }}" @if (old('status') == $status) selected @endif>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        @include('layouts.partials.error', ['name' => 'status'])
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
                                <option value="{{ $customer->id }}" @if (old('customer_id', request('customer_id')) == $customer->id) selected @endif>
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
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes') }}</textarea>

                        @include('layouts.partials.error', ['name' => 'notes'])
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.create') }}</button>
            </div>
        </form>
    </div>
@endsection
