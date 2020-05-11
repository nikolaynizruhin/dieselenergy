@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-white lead">
            {{ __('Category Details') }}
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-3">{{ __('Name') }}</div>
                <div class="col-md-6">{{ $category->name }}</div>
            </div>
        </div>
    </div>
@endsection
