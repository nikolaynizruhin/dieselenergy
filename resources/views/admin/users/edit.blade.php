@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('user.update') }}
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Name -->
                <div class="mb-3 row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('user.name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                        @include('layouts.partials.error', ['name' => 'name'])
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3 row">
                    <label for="inputEmail" class="col-md-3 col-form-label">{{ __('common.email') }}</label>
                    <div class="col-md-6">
                        <input type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                        @include('layouts.partials.error', ['name' => 'email'])
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('user.password.update') }}
        </div>

        <form action="{{ route('admin.users.password.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Password -->
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-md-3 col-form-label">{{ __('common.password') }}</label>
                    <div class="col-md-6">
                        <input type="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" name="password" required>

                        @include('layouts.partials.error', ['name' => 'password'])
                    </div>
                </div>

                <!-- Password Confirmation -->
                <div class="mb-3 row">
                    <label for="inputPasswordConfirmation" class="col-md-3 col-form-label">{{ __('user.password.confirm') }}</label>
                    <div class="col-md-6">
                        <input type="password" id="inputPasswordConfirmation" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-end border-0">
                <button type="submit" class="btn btn-primary text-white">{{ __('common.update') }}</button>
            </div>
        </form>
    </div>
@endsection
