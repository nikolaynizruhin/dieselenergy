@extends('layouts.app')

@section('title', 'Продаж та технічне обслуговування генераторів')

@section('description', 'Продаж генераторів. Сервісне обслуговування. Проєктні роботи. Технічна підтримка.')

@section('keywords', 'придбати генератор, дизель генератор, бензиновий генератор, джерело безперебійного живлення, сервісне обслуговування, проєктні роботи, технічна підтримка')

@section('content')
<section class="py-5">
    <div class="container position-relative py-md-7">
        <div class="dots top-0 start-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>

        <div class="row justify-content-center">
            <div class="col col-md-10 col-lg-9 text-center">
                <h1 class="fw-bold h2 text-uppercase mb-3">Надійні рішення для постачання <span class="text-primary">електроенергії</span></h1>
                <h2 class="text-muted h5 mb-4">Технічно продумані рішення та розробки найкращих світових інженерів дозволили нам стати партнером в обслуговуванні професійних дизельних електростанцій</h2>
{{--                <a href="{{ route('categories.products.index', \App\Models\Category::first()) }}" role="button" class="btn btn-primary text-white btn-lg mb-1 d-block d-sm-inline-block">Каталог товарів</a>--}}
                <a href="#contact" role="button" class="btn btn-primary text-white btn-lg mb-1 d-block d-sm-inline-block">Залишити заявку</a>
            </div>
        </div>

        <div class="dots bottom-0 end-0 height-72 width-48 position-absolute d-none d-md-block z-n1"></div>
    </div>
</section>

<section id="about-us" class="bg-light py-6">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center flex-column">
                <div class="text-center">
                    <h3 class="h2">Ми забезпечуємо стабільну роботу Вашого бізнесу</h3>
                    <h5 class="text-muted">Будуючи сучасні інженерні системи електроживлення</h5>
                </div>
                <br>
                <div class="card border-0">
                    <div class="card-body p-0 shadow-sm">
                        <div class="row m-0 divide-x divide-x-md-0 divide-y-md">
                            <div class="col-12 col-md p-4 text-center">
                                <p class="text-primary h1 fw-bold">{{ config('company.partners') }}</p>
                                <p class="text-muted h5">Партнерів</p>
                            </div>
                            <div class="col-12 col-md p-4 text-center">
                                <p class="text-primary h1 fw-bold">{{ date('Y') - config('company.year') }}</p>
                                <p class="text-muted h5">Років досвіду</p>
                            </div>
                            <div class="col-12 col-md p-4 text-center">
                                <p class="text-primary h1 fw-bold">{{ config('company.employees') }}</p>
                                <p class="text-muted h5">Робітників</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="position-relative py-6">
    <div class="container position-relative">
        <div class="dots top-0 start-0 width-40 height-64 position-absolute d-none d-md-block z-n1"></div>

        <div class="row justify-content-center mb-5">
            <div class="col col-md-8 text-center">
                <h5 class="text-primary h6 letter-spacing fw-bold">НАШІ ПОСЛУГИ</h5>
                <h3 class="h2">МИ ПРОПОНУЄМО</h3>
                <h4 class="text-muted h5">
                    Наш сервісний центр займається технічним обслуговуванням устаткування, з розробкою проєктної документації будь-якого рівня складності
                </h4>
            </div>
        </div>
        <div class="row text-center text-md-start mb-md-4">
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'basket', 'classes' => 'text-primary', 'width' => '2.2em', 'height' => '2.2em'])
                    </div>
                    <div class="col col-lg-9">
                        <h5>Продаж генераторів</h5>
                        <p class="text-muted">Ми продаємо: бензинові, дизельні, газові генератори, мотопомпи та блоки автоматики</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'tools', 'classes' => 'text-primary', 'width' => '2.2em', 'height' => '2.2em'])
                    </div>
                    <div class="col col-lg-9">
                        <h5>Сервісне обслуговування</h5>
                        <p class="text-muted">Встановлення, пусконалагодження, гарантійне, післягарантійне обслуговування та віддалений контроль</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center text-md-start">
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'people', 'classes' => 'text-primary', 'width' => '2.2em', 'height' => '2.2em'])
                    </div>
                    <div class="col col-lg-9">
                        <h5>Технічна підтримка</h5>
                        <p class="text-muted">Професійна діагностика, кваліфікований ремонт та відновленя працездатності, заміна панелей управління</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md mb-md-0 mb-3">
                <div class="row">
                    <div class="col-12 col-md-2 mb-3">
                        @include('layouts.partials.icon', ['name' => 'file-earmark-text', 'classes' => 'text-primary', 'width' => '2.2em', 'height' => '2.2em'])
                    </div>
                    <div class="col col-lg-9">
                        <h5>Проєктні роботи</h5>
                        <p class="text-muted">Схеми підключення обладнання, плани прокладення кабельних трас, розрахунки з вибору кабельної продукції</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dots bottom-0 end-0 width-40 height-64 position-absolute d-none d-md-block z-n1"></div>
    </div>
</section>

<section class="py-6">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h5 class="text-uppercase text-muted fw-bold letter-spacing">Нам довіряють</h5>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            <div class="col d-flex align-items-center bg-light p-5 justify-content-center border border-2 border-white">
                <img src="{{ asset('/images/logos/ictv.png') }}" alt="ICTV" height="60" width="151" loading="lazy">
            </div>
            <div class="col d-flex align-items-center bg-light p-5 justify-content-center border border-2 border-white">
                <img src="{{ asset('/images/logos/iev.png') }}" alt="IEV" height="60" width="159" loading="lazy">
            </div>
            <div class="col d-flex align-items-center bg-light p-5 justify-content-center border border-2 border-white">
                <img src="{{ asset('/images/logos/motto.png') }}" alt="MOTTO" height="60" width="202" loading="lazy">
            </div>
            <div class="col d-flex align-items-center bg-light p-5 justify-content-center border border-2 border-white">
                <img src="{{ asset('/images/logos/figaro.svg') }}" alt="Figaro" height="50" width="184" loading="lazy">
            </div>
            <div class="col d-flex align-items-center bg-light p-5 justify-content-center border border-2 border-white">
                <img src="{{ asset('/images/logos/metro.svg') }}" alt="Metro" height="60" width="156" loading="lazy">
            </div>
            <div class="col d-flex align-items-center bg-light p-5 justify-content-center border border-2 border-white">
                <img src="{{ asset('/images/logos/well.png') }}" alt="Небесна криниця" height="60" width="100" loading="lazy">
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-6">
    <div class="container">
        <h3 class="h2">Питання - відповіді</h3>
        <hr class="mb-2 mb-md-4">
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

<section id="contact" class="py-6">

    <div class="container position-relative">
        <div class="dots top-0 start-0 height-80 width-48 position-absolute d-none d-md-block z-n1"></div>

        <div class="row justify-content-center">
            <div class="col col-md-8 col-lg-6 col-xl-5 @if (session('status')) py-5 text-center @endif">

                @if (session('status'))
                    @include('layouts.partials.icon', ['name' => 'check-circle', 'classes' => 'text-success mb-3', 'width' => '4em', 'height' => '4em'])
                    <h3>Дякуємо!</h3>
                    <h5 class="text-muted">Ми зв'яжемося з Вами найближчим часом.</h5>
                @else
                    <h3 class="text-center h2">Зв'яжіться з нами</h3>
                    <h5 class="text-muted text-center mb-5">
                        Якщо у Вас є питання про дизель генератори, ми з радістю надамо відповідь
                    </h5>

                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf

                        @include('layouts.partials.honeypot')

                        <div class="mb-3">
                            <label for="inputName" class="fw-bold">Ім'я</label>
                            <input name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="inputName" value="{{ old('name') }}" autocomplete="name" required>

                            @include('layouts.partials.error', ['name' => 'name'])
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="fw-bold form-label">Email</label>
                            <input name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="inputEmail" value="{{ old('email') }}" autocomplete="email" required>

                            @include('layouts.partials.error', ['name' => 'email'])
                        </div>
                        <div class="mb-3">
                            <label for="inputPhone" class="fw-bold form-label">Телефон</label>
                            <input name="phone" type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="inputPhone" value="{{ old('phone', '+380') }}" pattern="[+]{1}380[0-9]{9}" autocomplete="phone" required>

                            @include('layouts.partials.error', ['name' => 'phone'])
                        </div>
                        <div class="mb-3">
                            <label for="inputMessage" class="fw-bold form-label">Ваше повідомлення</label>
                            <textarea name="message" class="form-control form-control-lg @error('message') is-invalid @enderror" id="inputMessage" rows="4">{{ old('message') }}</textarea>

                            @include('layouts.partials.error', ['name' => 'message'])
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input name="privacy" value="1" type="checkbox" class="form-check-input @error('privacy') is-invalid @enderror" @checked(old('privacy')) id="accept" required>
                            <label class="form-check-label text-muted" for="accept">Згода на <a href="{{ route('privacy') }}">обробку персональних даних</a></label>

                            @include('layouts.partials.error', ['name' => 'privacy'])
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary text-white btn-lg">Відправити</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div class="dots bottom-0 end-0 height-80 width-48 position-absolute d-none d-md-block z-n1"></div>
    </div>
</section>

@include('layouts.partials.services')
@endsection
