@extends('admin.layouts.auth')

@section('content')
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="form-group">
            <label for="email">{{ __('common.email') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">{{ __('common.password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="remember">{{ __('auth.remember') }}</label>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">
                {{ __('auth.login') }}
            </button>

            @if (Route::has('admin.password.request'))
                <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                    {{ __('auth.forgot') }}
                </a>
            @endif
        </div>
    </form>
@endsection
