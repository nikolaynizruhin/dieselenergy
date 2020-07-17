@extends('layouts.app')

@section('content')
    <div class="">
        <div class="container py-5">
            <div class="row mt-n3 mb-4">
                <div class="col letter-spacing d-flex align-items-center" style="color: #adb5bd; font-size: 16px">
                    Shop
                    <svg class="bi bi-chevron-right mx-2" width="0.9em" height="0.9em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    Generators
                </div>
                <div class="col text-right" style="color: #adb5bd; font-size: 16px">
                    Total Products: 38
                </div>
            </div>
            <div class="row">
                <div class="col-2">

                    <form>

                        <p class="mb-2 font-weight-bold text-uppercase letter-spacing" style="color: #adb5bd; font-size: 12px">Search</p>

                        <div class="form-group">
                            <label for="exampleInputEmail1" class="sr-only">Search</label>
                            <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter...">
                        </div>

                        <p class="mb-2 font-weight-bold text-uppercase letter-spacing" style="color: #adb5bd; font-size: 12px">Sort</p>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="sr-only">Example select</label>
                            <select class="form-control form-control-sm" id="exampleFormControlSelect1">
                                <option>A - Z</option>
                                <option>Z - A</option>
                            </select>
                        </div>

                        <p class="mb-2 font-weight-bold text-uppercase letter-spacing" style="color: #adb5bd; font-size: 12px">Power</p>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" style="color: #6c757d" for="defaultCheck1">
                                <small>30W</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                            <label class="form-check-label" style="color: #6c757d" for="defaultCheck2">
                                <small>40W</small>
                            </label>
                        </div>

                        <p class="mb-2 mt-4 font-weight-bold text-uppercase letter-spacing" style="color: #adb5bd; font-size: 12px">Voltage</p>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" style="color: #6c757d" for="defaultCheck1">
                                <small>100V</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                            <label class="form-check-label" style="color: #6c757d" for="defaultCheck2">
                                <small>200V</small>
                            </label>
                        </div>

                        <p class="mt-4 mb-2 font-weight-bold text-uppercase letter-spacing" style="color: #adb5bd; font-size: 12px">Type</p>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" style="color: #6c757d" for="defaultCheck1">
                                <small>Diesel</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                            <label class="form-check-label" style="color: #6c757d" for="defaultCheck2">
                                <small>Patrol</small>
                            </label>
                        </div>
                        <button type="submit" class="btn mt-3 btn-primary d-none btn-block">
                            Filter
                        </button>
                    </form>

                </div>
                <div class="col">
                    <div class="row">

                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body mb-n3">
                                    <h6 class="card-title">SDMO H-3100</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Diesel Generator</h6>
                                    <h5 class="card-title">$2 850.00</h5>
                                </div>
                                <div class="bg-light text-muted px-4 pt-3">
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">POWER</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">125W</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">WEIGHT</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">98kg</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">VOLTAGE</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">300V</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body mb-n3">
                                    <h6 class="card-title">SDMO H-3100</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Diesel Generator</h6>
                                    <h5 class="card-title">$4 500.00</h5>
                                </div>
                                <div class="bg-light text-muted px-4 pt-3">
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">POWER</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">125W</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">WEIGHT</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">98kg</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">VOLTAGE</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">300V</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body mb-n3">
                                    <h6 class="card-title">SDMO H-3100</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Diesel Generator</h6>
                                    <h5 class="card-title">$3 200.00</h5>
                                </div>
                                <div class="bg-light text-muted px-4 pt-3">
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">POWER</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">125W</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">WEIGHT</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">98kg</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">VOLTAGE</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">300V</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-2">

                </div>
                <div class="col">
                    <div class="row">

                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body mb-n3">
                                    <h6 class="card-title">SDMO H-3100</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Diesel Generator</h6>
                                    <h5 class="card-title">$2 850.00</h5>
                                </div>
                                <div class="bg-light text-muted px-4 pt-3">
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">POWER</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">125W</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">WEIGHT</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">98kg</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">VOLTAGE</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">300V</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body mb-n3">
                                    <h6 class="card-title">SDMO H-3100</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Diesel Generator</h6>
                                    <h5 class="card-title">$4 500.00</h5>
                                </div>
                                <div class="bg-light text-muted px-4 pt-3">
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">POWER</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">125W</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">WEIGHT</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">98kg</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">VOLTAGE</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">300V</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('/storage/images/cXeaYwhazLxNFIyz7dqcCzrXNuaGrbSYKYpPbavq.jpeg') }}" class="card-img-top" alt="...">
                                <div class="card-body mb-n3">
                                    <h6 class="card-title">SDMO H-3100</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Diesel Generator</h6>
                                    <h5 class="card-title">$3 200.00</h5>
                                </div>
                                <div class="bg-light text-muted px-4 pt-3">
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">POWER</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">125W</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">WEIGHT</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">98kg</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col letter-spacing" style="color: #adb5bd; font-size: 13px">VOLTAGE</div>
                                        <div class="col" style="font-size: 14px; color: #6c757d">300V</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-secondary btn-block">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <div class="row" style="color: rgb(173, 181, 189)">
                        <div class="col">Previous</div>
                        <div class="col text-center"><span class="text-muted">1</span>&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;3</div>
                        <div class="col text-right">Next</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
