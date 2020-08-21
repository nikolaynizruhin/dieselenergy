@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mt-n3 mb-4 text-gray-500">
            <div class="col letter-spacing d-flex align-items-center">
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
            <div class="col-lg-8">
                @if ($items->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table border">
                            <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td class="align-middle @if ($loop->first) border-top-0 @endif">
                                        <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" width="100" alt="...">
                                    </td>
                                    <td class="align-middle @if ($loop->first) border-top-0 @endif">
                                        <span class="font-weight-bold">{{ $item->name }}</span>
                                        <br>
                                        <span class="text-muted">{{ $item->category }}</span>
                                    </td>
                                    <td class="align-middle @if ($loop->first) border-top-0 @endif">@usd($item->price)</td>
                                    <td class="align-middle @if ($loop->first) border-top-0 @endif">
                                        <form action="{{ route('carts.update', $key) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mb-0">
                                                <label for="quantity" class="sr-only">Amount</label>
                                                <input type="number" name="quantity" onchange="this.form.submit()" value="{{ $item->quantity }}" min="1" class="form-control" id="quantity" aria-describedby="quantityHelp">
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle @if ($loop->first) border-top-0 @endif">@usd($item->total())</td>
                                    <td class="align-middle @if ($loop->first) border-top-0 @endif">
                                        <form action="{{ route('carts.destroy', $key) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                                                    <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4">Total:</td>
                                <td colspan="2">@usd($total)</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>Cart is empty</p>
                @endif
            </div>
            <div class="col-lg-4">
                @if ($items->isNotEmpty())
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="inputName" required autocomplete="name" autofocus>

                                    @error('name')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="inputEmail" aria-describedby="emailHelp" required autocomplete="email">

                                    @error('email')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputPhone">Phone</label>
                                    <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" id="inputPhone" required autocomplete="phone">

                                    @error('phone')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputNotes">Notes</label>
                                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="inputNotes" rows="3">{{ old('notes') }}</textarea>

                                    @error('notes')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Order for @usd($total)</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
