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
                    <svg width="5em" height="5em" viewBox="0 0 16 16" class="bi bi-check2-circle text-success" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
                    </svg>
                </p>
                <h1>Congratulations.<br>Your order is accepted.</h1>
                <p class="text-muted">Thank you for your order! Your order is being processed and will be completed within 3-6 hours. You will receive an email confirmation when your order is completed.</p>
                <p class="text-muted">Your order number: QW341JK</p>
            </div>
        </div>
    </div>
@endsection
