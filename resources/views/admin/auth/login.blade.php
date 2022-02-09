@extends('admin.layouts.auth')

@section('content')
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="email">{{ __('common.email') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @include('layouts.partials.error', ['name' => 'email'])
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">{{ __('common.password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @include('layouts.partials.error', ['name' => 'password'])
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="remember" id="remember" @checked(old('remember'))>
            <label class="form-check-label" for="remember">{{ __('auth.remember') }}</label>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary text-white">
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
