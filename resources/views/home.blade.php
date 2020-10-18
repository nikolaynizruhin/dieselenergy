@extends('layouts.app')

@section('content')
<section id="hero" class="position-relative py-7">
    <div class="dots ml-sm-5 mt-5 top-0 left-0 height-72 width-48 position-absolute"></div>
    <div class="dots mr-sm-5 mb-5 bottom-0 right-0 height-72 width-48 position-absolute"></div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md">
                <h1 class="font-weight-bold">Energy Power</h1>
                <h5 class="text-primary">the energy everywhere</h5>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, doloremque eius enim fugit possimus soluta unde ut voluptas? Aperiam beatae debitis distinctio, dolorem error facere inventore itaque neque sit tempora.</p>
                <button type="button" class="btn btn-primary btn-lg">Shop</button>
                <a href="#contact" role="button" class="btn btn-outline-secondary btn-lg mr-2">Contact Us</a>
            </div>
            <div class="col-12 col-md d-none d-md-block">
                <img src="{{ asset('images/wind-turbine.svg') }}" alt="Wind turbine" width="100%">
            </div>
        </div>
    </div>
</section>

<section id="numbers" class="bg-light py-6">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center flex-column">
                <div class="text-center">
                    <h2>Trusted by companies all around the world</h2>
                    <h5 class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
                </div>
                <br>
                <div class="card border-0">
                    <div class="card-body p-0 shadow-sm">
                        <div class="row m-0 divide-x divide-x-md-0 divide-y-md">
                            <div class="col-12 col-md p-4 text-center">
                                <h1 class="text-primary font-weight-bold">15</h1>
                                <h5 class="text-muted">Companies</h5>
                            </div>
                            <div class="col-12 col-md p-4 text-center">
                                <h1 class="text-primary font-weight-bold">5</h1>
                                <h5 class="text-muted">Years</h5>
                            </div>
                            <div class="col-12 col-md p-4 text-center">
                                <h1 class="text-primary font-weight-bold">10</h1>
                                <h5 class="text-muted">Employees</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="position-relative py-6">
    <div class="dots mt-7 top-0 left-0 width-40 height-64 position-absolute"></div>
    <div class="dots bottom-0 right-0 width-40 height-64 position-absolute"></div>

    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col col-md-8 text-center">
                <h6 class="text-primary letter-spacing font-weight-bold">SERVICES</h6>
                <h2>We can help you to build a better future</h2>
                <h5 class="text-muted">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ad aperiam architecto aspernatur aut culpa.
                </h5>
            </div>
        </div>
        <div class="row text-center text-md-left mb-md-4">
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'basket', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Shop</h5>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis dolores iste non praesentium quod. Aliquam animi deleniti esse necessitatibus numquam pariatur quis.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'tools', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Installation</h5>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis dolores iste non praesentium quod. Aliquam animi deleniti esse necessitatibus numquam pariatur quis.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center text-md-left">
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'award', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Support</h5>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis dolores iste non praesentium quod. Aliquam animi deleniti esse necessitatibus numquam pariatur quis.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'info-circle', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Consulting</h5>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis dolores iste non praesentium quod. Aliquam animi deleniti esse necessitatibus numquam pariatur quis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="companies" class="py-6">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h5 class="text-uppercase text-muted font-weight-bold letter-spacing">Trusted by companies</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                @include('layouts.partials.icon', ['name' => 'bootstrap', 'classes' => 'text-gray-500', 'width' => '2.5em', 'height' => '2.5em'])
                <h3 class="mb-0 ml-3 text-gray-500">Bootstrap</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                @include('layouts.partials.icon', ['name' => 'shop', 'classes' => 'text-gray-500', 'width' => '2.5em', 'height' => '2.5em'])
                <h3 class="mb-0 ml-3 text-gray-500">Stripe</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                @include('layouts.partials.icon', ['name' => 'kanban', 'classes' => 'text-gray-500', 'width' => '2.5em', 'height' => '2.5em'])
                <h3 class="mb-0 ml-3 text-gray-500">Trello</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                @include('layouts.partials.icon', ['name' => 'hand-index', 'classes' => 'text-gray-500', 'width' => '2.5em', 'height' => '2.5em'])
                <h3 class="mb-0 ml-3 text-gray-500">Hand</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                @include('layouts.partials.icon', ['name' => 'bootstrap-reboot', 'classes' => 'text-gray-500', 'width' => '2.5em', 'height' => '2.5em'])
                <h3 class="mb-0 ml-3 text-gray-500">Rollback</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                @include('layouts.partials.icon', ['name' => 'calendar2-check', 'classes' => 'text-gray-500', 'width' => '2.5em', 'height' => '2.5em'])
                <h3 class="mb-0 ml-3 text-gray-500">Calendly</h3>
            </div>
        </div>
    </div>
</section>

<section id="faq" class="bg-light py-6">
    <div class="container">
        <h2>Frequently Asked Questions</h2>
        <hr class="pb-2 pb-md-4">
        <div class="row mb-md-4">
            <div class="col-12 col-md-6">
                <h4>Dolor hic laboriosam voluptate?</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, aperiam eos facilis libero porro saepe. Aliquam consectetur doloribus ducimus eos harum temporibus unde.</p>
            </div>
            <div class="col-12 col-md-6">
                <h4>What ist hic laboriosam voluptate?</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, aperiam eos facilis libero porro saepe. Aliquam consectetur doloribus ducimus eos harum temporibus unde.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <h4>Iusto, nobis perspiciatis porro quae saepe ullam?</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, aperiam eos facilis libero porro saepe. Aliquam consectetur doloribus ducimus eos harum temporibus unde.</p>
            </div>
            <div class="col-12 col-md-6">
                <h4>What is the best country to live?</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, aperiam eos facilis libero porro saepe. Aliquam consectetur doloribus ducimus eos harum temporibus unde.</p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="position-relative py-6">
    <div class="dots mt-5 top-0 left-0 height-80 width-48 position-absolute"></div>
    <div class="dots mb-6 bottom-0 right-0 height-80 width-48 position-absolute"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 col-lg-6">
                <h2 class="text-center">Contact Us</h2>
                <h5 class="text-muted text-center mb-5">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Ab ad aperiam architecto aspernatur aut culpa.
                </h5>

                @if (session('status'))
                    <div class="row">
                        <div class="col text-center">
                            @include('layouts.partials.icon', ['name' => 'check-circle', 'classes' => 'text-success mb-3', 'width' => '4em', 'height' => '4em'])
                            <h3>Thank you!</h3>
                            <p class="text-muted">Thank you for contacting us! Your contact is being processed and will be completed within 3-6 hours. You will receive an email confirmation when your order is completed.</p>
                        </div>
                    </div>
                @else
                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="inputName" class="font-weight-bold">Name</label>
                            <input name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="inputName" value="{{ old('name') }}" autocomplete="name" required>

                            @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="font-weight-bold">Email address</label>
                            <input name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="inputEmail" value="{{ old('email') }}" aria-describedby="emailHelp" autocomplete="email" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>

                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="font-weight-bold">Phone Number</label>
                            <input name="phone" type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="inputPhone" value="{{ old('phone') }}" aria-describedby="phoneHelp" autocomplete="phone" required>
                            <small id="phoneHelp" class="form-text text-muted">Phone number format: +380631683321</small>

                            @error('phone')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputMessage" class="font-weight-bold">Message</label>
                            <textarea name="message" class="form-control form-control-lg @error('message') is-invalid @enderror" id="inputMessage" rows="4">{{ old('message') }}</textarea>

                            @error('message')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input name="terms" value="1" type="checkbox" class="custom-control-input @error('terms') is-invalid @enderror" @if(old('terms')) checked @endif id="accept">
                            <label class="custom-control-label text-muted" for="accept">By selecting this, you agree to the Privacy Policy</label>

                            @error('terms')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Let's Talk</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
