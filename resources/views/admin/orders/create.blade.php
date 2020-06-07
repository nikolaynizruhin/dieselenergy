@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Add Order') }}
        </div>

        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
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
                                <option value="{{ $status }}" @if (old('status') == $status) selected @endif>
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

                <!-- Customer -->
                <div class="form-group row">
                    <label for="selectCustomer" class="col-md-3 col-form-label">{{ __('customer.title') }}</label>
                    <div class="col-md-6">
                        <select id="selectCustomer"
                                class="form-control @error('customer_id') is-invalid @enderror"
                                name="customer_id"
                                required>
                            <option value="">Select a customer...</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @if (old('customer_id') == $customer->id) selected @endif>
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
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes') }}</textarea>

                        @error('notes')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
            </div>
        </form>
    </div>
@endsection
