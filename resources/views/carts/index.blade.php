@extends('layouts.app')

@section('content')
    <div>
        <div class="container py-5">
            <div class="row mt-n3 mb-4">
                <div class="col letter-spacing d-flex align-items-center" style="color: #adb5bd; font-size: 16px">
                    Shop
                    <svg class="bi bi-chevron-right mx-2" width="0.8em" height="0.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    Cart
                </div>
            </div>
            <h2 class="text-center">Shipping Cart</h2>
            <h5 class="text-center text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
            <br>
            <div class="row">
                <div class="col-8">
                    <table class="table" style="border: 1px solid #dee2e6">
                        <thead class="d-none">
                        <tr>
                            <th scope="col" class="text-center">Item</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" style="width: 12%" class="text-center">Quantity</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $item)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" width="100" alt="...">
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-bold">{{ $item->name }}</span>
                                                <span class="text-muted">{{ $item->category }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle @if ($loop->first) border-top-0 @endif">@usd($item->price)</td>
                                <td style="width: 12%" class="align-middle @if ($loop->first) border-top-0 @endif">
                                    <div class="form-group mb-0">
                                        <label for="exampleInputEmail1" class="sr-only">Amount</label>
                                        <input type="number" value="{{ $item->quantity }}" min="1" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                </td>
                                <td class="align-middle @if ($loop->first) border-top-0 @endif">@usd($item->total())</td>
                                <td class="align-middle @if ($loop->first) border-top-0 @endif">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                                        <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                                    </svg>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="align-middle">Total:</td>
                            <td></td>
                            <td></td>
                            <td class="align-middle">$8 350</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Notes</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Order for $1500</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
