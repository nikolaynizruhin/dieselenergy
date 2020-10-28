@extends('layouts.app')

@section('content')
<section id="hero" class="position-relative py-7">
    <div class="dots ml-sm-5 mt-5 top-0 left-0 height-72 width-48 position-absolute"></div>
    <div class="dots mr-sm-5 mb-5 bottom-0 right-0 height-72 width-48 position-absolute"></div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md">
                <h1 class="font-weight-bold">DIESEL ENERGY</h1>
                <h5 class="text-primary">надійні рішення для постачання<br>електроенергії</h5>
                <p class="text-muted">Технічно продумані рішення та розробки найкращих світових інженерів дозволили нам стати партнером в обслуговуванні професійних дизельних електростанцій.</p>
                <button type="button" class="btn btn-primary btn-lg">Каталог товарів</button>
                <a href="#contact" role="button" class="btn btn-outline-secondary btn-lg mr-2">Залишити заявку</a>
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
                    <h2>Ми забезпечуємо стабільну роботу Вашого бізнесу</h2>
                    <h5 class="text-muted">Будуючи сучасні інженерні системи електроживлення</h5>
                </div>
                <br>
                <div class="card border-0">
                    <div class="card-body p-0 shadow-sm">
                        <div class="row m-0 divide-x divide-x-md-0 divide-y-md">
                            <div class="col-12 col-md p-4 text-center">
                                <h1 class="text-primary font-weight-bold">15</h1>
                                <h5 class="text-muted">Партнерів</h5>
                            </div>
                            <div class="col-12 col-md p-4 text-center">
                                <h1 class="text-primary font-weight-bold">7</h1>
                                <h5 class="text-muted">Років досвіду</h5>
                            </div>
                            <div class="col-12 col-md p-4 text-center">
                                <h1 class="text-primary font-weight-bold">12</h1>
                                <h5 class="text-muted">Робітників</h5>
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
                <h6 class="text-primary letter-spacing font-weight-bold">НАШІ ПОСЛУГИ</h6>
                <h2>МИ ПРОПОНУЄМО</h2>
                <h5 class="text-muted">
                    Наш сервісний центр займається технічним обслуговуванням устаткування, з розробкою проєктної документації будь-якого рівня складності.
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
                        <h5>Продаж генераторів</h5>
                        <p class="text-muted">Ми продаємо: бензинові, дизельні, газові генератори, мотопомпи та блоки автоматики.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'tools', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Сервісне обслуговування</h5>
                        <p class="text-muted">Встановлення, пусконалагодження, гарантійне, післягарантійне обслуговування та віддалений контроль.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center text-md-left">
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'people', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Технічна підтримка</h5>
                        <p class="text-muted">Професійна діагностика, кваліфікований ремонт та відновленя працездатності, заміна панелей управління.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'file-earmark-text', 'classes' => 'text-primary', 'width' => '2em', 'height' => '2em'])
                    </div>
                    <div class="col">
                        <h5>Проєктні роботи</h5>
                        <p class="text-muted">Схеми підключення обладнання, плани прокладення кабельних трас, розрахунки з вибору кабельної продукції</p>
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
                <h5 class="text-uppercase text-muted font-weight-bold letter-spacing">Нам довіряють</h5>
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
        <h2>Питання - відповіді</h2>
        <hr class="pb-2 pb-md-4">
        <div class="row mb-md-4">
            <div class="col-12 col-md-6">
                <h4>Який генератор краще — бензиновий або дизельний?</h4>
                <p class="text-muted">Бензинові міні-електростанції працюють тихше, мають більш компактні розміри та малу вагу. Вони доступніше дизельних по вартості.
                    Дизельні генератори мають більший моторесурс, ніж бензинові агрегати. В них не такі великі витрати палива.</p>
            </div>
            <div class="col-12 col-md-6">
                <h4>Як влаштований та працює бензиновий генератор?</h4>
                <p class="text-muted">Всередині приладу знаходиться двигун внутрішнього згоряння. Його вал передає обертання котушці, яка знаходиться між магнітами. Коли котушка перетинає лінії магнітного поля, в ній виробляється електричний струм.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <h4>Скільки годин може безперервно працювати дизель генератор?</h4>
                <p class="text-muted">Час безперервної роботи залежить від вимог по експлуатації. Наприклад, дизельний генератор з повітряним охолодженням може працювати не більше 8-10 годин. Потім його потрібно відключити, дати охолонути і заправити мастилом. При такому інтенсивному щоденному використанні його потрібно міняти кожні 50 годин. У разі менш інтенсивної експлуатації (запуск на короткий час 1-2 рази в тиждень) - вистачає на 100 годин.</p>
            </div>
            <div class="col-12 col-md-6">
                <h4>В чому полягає техобслуговування дизель генератора?</h4>
                <p class="text-muted">Перед кожним запуском необхідно постійно контролювати рівень палива, регулярно замінювати масло і чистити фільтри та перевіряти надійність електричних контактів. Особливу увагу варто приділити тим генераторам, які мало і рідко використовуються. Їх потрібно мінімум один раз на місяць запускати при зниженому навантаженні на потужності до 75%. Це потрібно для напрацювання необхідного моторесурсу і збільшення терміну служби.</p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="position-relative py-6">
    <div class="dots mt-5 top-0 left-0 height-80 width-48 position-absolute"></div>
    <div class="dots mb-6 bottom-0 right-0 height-80 width-48 position-absolute"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-8 col-lg-6 @if (session('status')) py-5 text-center @endif">

                @if (session('status'))
                    @include('layouts.partials.icon', ['name' => 'check-circle', 'classes' => 'text-success mb-3', 'width' => '4em', 'height' => '4em'])
                    <h3>Дякуємо!</h3>
                    <h5 class="text-muted">Ми зв'яжемося з Вами найближчим часом.</h5>
                @else
                    <h2 class="text-center">Зв'яжіться з нами</h2>
                    <h5 class="text-muted text-center mb-5">
                        Якщо у Вас є питання про дизель генератори, ми з радістю надамо Вам відповідь.
                    </h5>

                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="inputName" class="font-weight-bold">Ім'я</label>
                            <input name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="inputName" value="{{ old('name') }}" autocomplete="name" required>

                            @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="font-weight-bold">Email</label>
                            <input name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="inputEmail" value="{{ old('email') }}" aria-describedby="emailHelp" autocomplete="email" required>
                            <small id="emailHelp" class="form-text text-muted"></small>

                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="font-weight-bold">Телефон</label>
                            <input name="phone" type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="inputPhone" value="{{ old('phone') }}" aria-describedby="phoneHelp" autocomplete="phone" required>
                            <small id="phoneHelp" class="form-text text-muted">Формат номеру: +380631683321</small>

                            @error('phone')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputMessage" class="font-weight-bold">Ваше повідомлення</label>
                            <textarea name="message" class="form-control form-control-lg @error('message') is-invalid @enderror" id="inputMessage" rows="4">{{ old('message') }}</textarea>

                            @error('message')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input name="privacy" value="1" type="checkbox" class="custom-control-input @error('privacy') is-invalid @enderror" @if(old('privacy')) checked @endif id="accept" required>
                            <label class="custom-control-label text-muted" for="accept">Згода на  <a href="{{ route('privacy') }}">обробку персональних даних</a></label>

                            @error('privacy')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Відправити</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
