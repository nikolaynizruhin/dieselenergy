@extends('layouts.app')

@section('content')
<section id="hero" class="position-relative">
    <div class="dots dots-left position-absolute d-none d-sm-block"></div>
    <div class="dots dots-right position-absolute"></div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md">
                <h1 class="font-weight-bold">Energy Power</h1>
                <h5 class="text-primary">the energy everywhere</h5>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, doloremque eius enim fugit possimus soluta unde ut voluptas? Aperiam beatae debitis distinctio, dolorem error facere inventore itaque neque sit tempora.</p>
                <button type="button" class="btn btn-primary btn-lg mr-2">Contact Us</button>
                <button type="button" class="btn btn-outline-secondary btn-lg">Shop</button>
            </div>
            <div class="col-12 col-md d-none d-md-block">
                <img src="{{ asset('images/wind-turbine.svg') }}" alt="" width="100%">
            </div>
        </div>
    </div>
</section>

<section id="numbers" class="bg-light">
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
                        <div class="row m-0">
                            <div class="col-12 col-md p-4 text-center box">
                                <h1 class="text-primary font-weight-bold">15</h1>
                                <h5 class="text-muted">Companies</h5>
                            </div>
                            <div class="col-12 col-md p-4 text-center box">
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

<section id="services" class="position-relative">
    <div class="dots dots-left position-absolute d-none d-sm-block"></div>
    <div class="dots dots-right position-absolute"></div>

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
                        <svg class="bi bi-basket text-primary" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.243 1.071a.5.5 0 0 1 .686.172l3 5a.5.5 0 1 1-.858.514l-3-5a.5.5 0 0 1 .172-.686zm-4.486 0a.5.5 0 0 0-.686.172l-3 5a.5.5 0 1 0 .858.514l3-5a.5.5 0 0 0-.172-.686z"/>
                            <path fill-rule="evenodd" d="M1 7v1h14V7H1zM.5 6a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h15a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5H.5z"/>
                            <path fill-rule="evenodd" d="M14 9H2v5a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V9zM2 8a1 1 0 0 0-1 1v5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9a1 1 0 0 0-1-1H2z"/>
                            <path fill-rule="evenodd" d="M4 10a.5.5 0 0 1 .5.5v3a.5.5 0 1 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 1 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 1 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 1 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 1 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg>
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
                        <svg class="bi bi-tools text-primary" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/>
                            <path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
                        </svg>
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
                        <svg class="bi bi-award text-primary" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.669.864L8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193l-1.51-.229L8 1.126l-1.355.702-1.51.229-.684 1.365-1.086 1.072L3.614 6l-.25 1.506 1.087 1.072.684 1.365 1.51.229L8 10.874l1.356-.702 1.509-.229.684-1.365 1.086-1.072L12.387 6l.248-1.506-1.086-1.072-.684-1.365z"/>
                            <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                        </svg>
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
                        <svg class="bi bi-info-circle text-primary" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                            <circle cx="8" cy="4.5" r="1"/>
                        </svg>
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

<section id="companies">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h5 class="text-uppercase text-muted font-weight-bold letter-spacing">Trusted by companies</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center box">
                <svg class="bi bi-bootstrap text-muted opacity-60" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M12 1H4a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V4a3 3 0 0 0-3-3zM4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4z"/><path fill-rule="evenodd" d="M8.537 12H5.062V3.545h3.399c1.587 0 2.543.809 2.543 2.11 0 .884-.65 1.675-1.483 1.816v.1c1.143.117 1.904.931 1.904 2.033 0 1.488-1.084 2.396-2.888 2.396zM6.375 4.658v2.467h1.558c1.16 0 1.764-.428 1.764-1.23 0-.78-.569-1.237-1.541-1.237H6.375zm1.898 6.229H6.375V8.162h1.822c1.236 0 1.887.463 1.887 1.348 0 .896-.627 1.377-1.811 1.377z"/>
                </svg>
                <h3 class="mb-0 ml-3 text-muted opacity-60">Bootstrap</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center box">
                <svg class="bi bi-shop text-muted opacity-60" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M0 15.5a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5zM3.12 1.175A.5.5 0 0 1 3.5 1h9a.5.5 0 0 1 .38.175l2.759 3.219A1.5 1.5 0 0 1 16 5.37v.13h-1v-.13a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.13H0v-.13a1.5 1.5 0 0 1 .361-.976l2.76-3.22z"/>
                    <path d="M2.375 6.875c.76 0 1.375-.616 1.375-1.375h1a1.375 1.375 0 0 0 2.75 0h1a1.375 1.375 0 0 0 2.75 0h1a1.375 1.375 0 1 0 2.75 0h1a2.375 2.375 0 0 1-4.25 1.458 2.371 2.371 0 0 1-1.875.917A2.37 2.37 0 0 1 8 6.958a2.37 2.37 0 0 1-1.875.917 2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.5h1c0 .76.616 1.375 1.375 1.375z"/>
                    <path d="M4.75 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm3.75 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm3.75 0a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                    <path fill-rule="evenodd" d="M2 7.846V7H1v.437c.291.207.632.35 1 .409zm-1 .737c.311.14.647.232 1 .271V15H1V8.583zm13 .271a3.354 3.354 0 0 0 1-.27V15h-1V8.854zm1-1.417c-.291.207-.632.35-1 .409V7h1v.437zM3 9.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5V15H7v-5H4v5H3V9.5zm6 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-4zm1 .5v3h2v-3h-2z"/>
                </svg>
                <h3 class="mb-0 ml-3 text-muted opacity-60">Stripe</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center box">
                <svg class="bi bi-kanban text-muted opacity-60" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M13.5 1h-11a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm-11-1a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-11z"/>
                    <rect width="3" height="5" x="6.5" y="2" rx="1"/>
                    <rect width="3" height="9" x="2.5" y="2" rx="1"/>
                    <rect width="3" height="12" x="10.5" y="2" rx="1"/>
                </svg>
                <h3 class="mb-0 ml-3 text-muted opacity-60">Trello</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center box">
                <svg class="bi bi-hand-index text-muted opacity-60" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M6.75 1a.75.75 0 0 0-.75.75V9a.5.5 0 0 1-1 0v-.89l-1.003.2a.5.5 0 0 0-.399.546l.345 3.105a1.5 1.5 0 0 0 .243.666l1.433 2.15a.5.5 0 0 0 .416.223h6.385a.5.5 0 0 0 .434-.252l1.395-2.442a2.5 2.5 0 0 0 .317-.991l.272-2.715a1 1 0 0 0-.995-1.1H13.5v1a.5.5 0 0 1-1 0V7.154a4.208 4.208 0 0 0-.2-.26c-.187-.222-.368-.383-.486-.43-.124-.05-.392-.063-.708-.039a4.844 4.844 0 0 0-.106.01V8a.5.5 0 0 1-1 0V5.986c0-.167-.073-.272-.15-.314a1.657 1.657 0 0 0-.448-.182c-.179-.035-.5-.04-.816-.027l-.086.004V8a.5.5 0 0 1-1 0V1.75A.75.75 0 0 0 6.75 1zM8.5 4.466V1.75a1.75 1.75 0 0 0-3.5 0v5.34l-1.199.24a1.5 1.5 0 0 0-1.197 1.636l.345 3.106a2.5 2.5 0 0 0 .405 1.11l1.433 2.15A1.5 1.5 0 0 0 6.035 16h6.385a1.5 1.5 0 0 0 1.302-.756l1.395-2.441a3.5 3.5 0 0 0 .444-1.389l.272-2.715a2 2 0 0 0-1.99-2.199h-.582a5.184 5.184 0 0 0-.195-.248c-.191-.229-.51-.568-.88-.716-.364-.146-.846-.132-1.158-.108l-.132.012a1.26 1.26 0 0 0-.56-.642 2.634 2.634 0 0 0-.738-.288c-.31-.062-.739-.058-1.05-.046l-.048.002zm2.094 2.025z"/>
                </svg>
                <h3 class="mb-0 ml-3 text-muted opacity-60">Hand</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center box">
                <svg class="bi bi-bootstrap-reboot text-muted opacity-60" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 0 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.812 6.812 0 0 0 1.16 8zm5.48-.079V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324h-1.6zm0 3.75V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352h1.141z"/>
                </svg>
                <h3 class="mb-0 ml-3 text-muted opacity-60">Rollback</h3>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center box">
                <svg class="bi bi-calendar2-check text-muted opacity-60" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M14 2H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM2 1a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                </svg>
                <h3 class="mb-0 ml-3 text-muted opacity-60">Calendly</h3>
            </div>
        </div>
    </div>
</section>

<section class="bg-light">
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

<section id="contact" class="position-relative">
    <div class="dots dots-left position-absolute d-none d-sm-block"></div>
    <div class="dots dots-right position-absolute"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 col-lg-6">
                <h2 class="text-center">Contact Us</h2>
                <h5 class="text-muted text-center">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Ab ad aperiam architecto aspernatur aut culpa.
                </h5>

                <br>

                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="font-weight-bold">Name</label>
                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="font-weight-bold">Company</label>
                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="font-weight-bold">Email address</label>
                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="font-weight-bold">Phone Number</label>
                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="font-weight-bold">Message</label>
                        <textarea class="form-control form-control-lg" id="exampleFormControlTextarea1" rows="4"></textarea>
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label text-muted" for="customSwitch1">By selecting this, you agree to the Privacy Policy</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Let's Talk</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
