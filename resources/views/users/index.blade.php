@extends('layouts.app')

@section('content')

    @include('layouts.partials.alert')

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('users.index') }}" method="GET">
                <div class="form-group">
                    <label for="search" class="sr-only">{{ __('Search') }}</label>
                    <input type="text" name="search" class="form-control shadow-sm border-0" id="search" aria-describedby="search" placeholder="Search...">
                </div>
            </form>
        </div>
        <div class="col text-right">
            <a class="btn btn-primary d-block d-md-inline-block shadow-sm mb-3" href="{{ route('users.create') }}" role="button">{{ __('Add User') }}</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @include('users.partials.list')
        </div>
        <div class="card-footer bg-white text-muted">
            <div class="d-flex justify-content-between align-items-center">
                About {{ $users->total() }} results
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
