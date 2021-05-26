@extends('admin.layouts.auth')

@section('content')
    <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="email">{{ __('common.email') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary text-white">
            {{ __('auth.reset_link') }}
        </button>
    </form>
@endsection
