@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header border-0 bg-white lead">
            {{ __('Update Profile') }}
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Name -->
                <div class="form-group row">
                    <label for="inputName" class="col-md-3 col-form-label">{{ __('Name') }}</label>
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group row">
                    <label for="inputEmail" class="col-md-3 col-form-label">{{ __('Email') }}</label>
                    <div class="col-md-6">
                        <input type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                        @error('email')
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

    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Update Password') }}
        </div>

        <form action="{{ route('admin.users.password.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Password -->
                <div class="form-group row">
                    <label for="inputPassword" class="col-md-3 col-form-label">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input type="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" name="password" required>

                        @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Password Confirmation -->
                <div class="form-group row">
                    <label for="inputPasswordConfirmation" class="col-md-3 col-form-label">{{ __('Password Confirmation') }}</label>
                    <div class="col-md-6">
                        <input type="password" id="inputPasswordConfirmation" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-right border-0">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
@endsection
