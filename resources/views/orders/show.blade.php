@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mt-n3 mb-4">
            <div class="col letter-spacing d-flex align-items-center" style="color: #adb5bd; font-size: 16px">
                Shop
                <svg class="bi bi-chevron-right mx-2" width="0.8em" height="0.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
                Order Confirmation
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-6 text-center">
                <p>
                    <svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-check-circle text-success" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                    </svg>
                </p>
                <h1>Congratulations.<br>Your order is accepted.</h1>
                <p class="text-muted">Thank you for your order! Your order is being processed and will be completed within 3-6 hours. You will receive an email confirmation when your order is completed.</p>
                <p class="text-muted">Your order number: QW341JK</p>
            </div>
        </div>
    </div>
@endsection
