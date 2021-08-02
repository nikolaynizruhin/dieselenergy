@extends('admin.layouts.auth')

@section('content')
    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label class="form-label" for="email">{{ __('common.email') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

            @include('layouts.partials.error', ['name' => 'email'])
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">{{ __('common.password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @include('layouts.partials.error', ['name' => 'password'])
        </div>

        <div class="mb-3">
            <label class="form-label" for="password-confirm">{{ __('auth.confirm') }}</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary text-white">
            {{ __('auth.reset') }}
        </button>
    </form>
@endsection
