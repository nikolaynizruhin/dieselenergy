@extends('layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('Update Order') }}
        </div>

        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <!-- Status -->
                <div class="form-group row">
                    <label for="selectStatus" class="col-md-3 col-form-label">{{ __('Status') }}</label>
                    <div class="col-md-6">
                        <select id="selectStatus"
                                class="form-control @error('status') is-invalid @enderror"
                                name="status"
                                required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if (old('status', $order->$status) == $status) selected @endif>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Total -->
                <div class="form-group row">
                    <label for="inputTotal" class="col-md-3 col-form-label">{{ __('Total') }}</label>
                    <div class="col-md-6">
                        <input type="number" id="inputTotal" class="form-control @error('total') is-invalid @enderror" value="{{ old('total', $order->total) }}" name="total" min="0" required>

                        @error('total')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Customer -->
                <div class="form-group row">
                    <label for="selectCustomer" class="col-md-3 col-form-label">{{ __('Customer') }}</label>
                    <div class="col-md-6">
                        <select id="selectCustomer"
                                class="form-control @error('customer_id') is-invalid @enderror"
                                name="customer_id"
                                required>
                            <option value="">Select a customer...</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @if (old('customer_id', $order->customer_id) == $customer->id) selected @endif>
                                    {{ $customer->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('customer_id')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group row">
                    <label for="inputNotes" class="col-md-3 col-form-label">{{ __('Notes') }}</label>
                    <div class="col-md-6">
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes', $order->notes) }}</textarea>

                        @error('notes')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
@endsection
