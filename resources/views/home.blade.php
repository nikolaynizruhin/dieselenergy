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
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/33/ICTV_logo.svg/1200px-ICTV_logo.svg.png" alt="" height="60">
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://iev.aero/_nuxt/img/logo@2x.2d2c20b.png" alt="" height="60">
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://motto.ua/wp-content/uploads/2018/11/logo_retina.png" alt="" height="60">
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://figaro.ua/images/logo-mini.svg" alt="" height="60">
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://www.mil.gov.ua/img/modlogo.svg" alt="" height="60">
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://www.favor.com.ua/images/cache/files/2000/2608m.svg" alt="" height="60">
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <svg height="60" width="100" viewBox="0 0 410.60001 212.61333"><defs id="defs6"><clipPath clipPathUnits="userSpaceOnUse" id="clipPath20"><path d="M 0,0 H 3079 V 1594.59 H 0 Z" id="path18"></path></clipPath></defs><g id="g10" transform="matrix(1.3333333,0,0,-1.3333333,0,212.61333)"><g id="g12" transform="scale(0.1)"><g id="g14"><g clip-path="url(#clipPath20)" id="g16"><path d="M 0,517.262 H 94.1602 V 330.16 L 267.805,517.262 H 381.527 L 207.273,335.672 389.477,89.2695 H 276.363 L 143.688,271.469 94.1602,220.109 V 89.2695 H 0 V 517.262" id="path22" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 615.141,301.422 c 47.082,0 74.589,28.129 74.589,66.039 0,42.187 -29.343,64.809 -76.425,64.809 H 540.547 V 301.422 Z m -168.754,215.84 h 174.867 c 102.105,0 163.863,-60.532 163.863,-149.192 0,-99.05 -77.043,-150.41 -173.031,-150.41 H 540.547 V 89.2695 h -94.16 V 517.262" id="path24" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 1223.55,89.2695 h -92.93 V 369.91 L 943.52,89.2695 H 854.863 V 517.262 h 92.942 V 236.621 l 188.315,280.641 h 87.43 V 89.2695" id="path26" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 1326.32,517.262 h 94.16 V 347.898 h 173.64 v 169.364 h 94.16 V 89.2695 h -94.16 V 261.07 H 1420.48 V 89.2695 h -94.16 V 517.262" id="path28" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="M 2159.74,89.2695 H 2066.8 V 369.91 L 1879.71,89.2695 h -88.66 V 517.262 h 92.94 V 236.621 l 188.31,280.641 h 87.44 V 89.2695" id="path30" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="M 2579.83,89.2695 H 2262.5 V 517.262 h 94.17 v -343 h 168.75 v 343 h 94.16 v -343 h 50.74 L 2658.1,0 h -78.27 v 89.2695" id="path32" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="M 2980.98,309.371 V 432.27 h -93.55 c -45.86,0 -73.98,-20.79 -73.98,-62.36 0,-36.07 26.29,-60.539 72.15,-60.539 z m 94.16,-220.1015 h -94.16 V 226.219 h -73.99 L 2815.28,89.2695 h -110.06 l 104.56,152.8515 c -54.42,20.168 -91.71,63.59 -91.71,133.899 0,88.66 61.14,141.242 161.41,141.242 h 195.66 V 89.2695" id="path34" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 234.242,887.441 h 50.461 v -89.238 h 97.168 v 89.238 h 50.457 V 667.254 h -50.457 v 88.828 h -97.168 v -88.828 h -50.461 v 220.187" id="path36" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 646.688,792.781 c -3.333,32.52 -22.516,57.961 -55.875,57.961 -30.868,0 -52.551,-23.769 -57.137,-57.961 z M 483.633,777.352 c 0,62.968 44.625,114.679 107.594,114.679 70.058,0 105.507,-55.051 105.507,-118.437 0,-3.332 -0.421,-11.672 -0.836,-14.18 H 534.094 c 5.422,-35.859 30.855,-55.879 63.386,-55.879 24.606,0 42.122,9.18 59.633,26.27 l 29.61,-26.27 c -20.848,-25.019 -49.621,-41.281 -90.078,-41.281 -63.801,0 -113.012,46.289 -113.012,115.098" id="path38" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 918.59,773.594 c 0,37.539 -27.52,67.976 -64.219,67.976 -37.113,0 -62.969,-30.031 -62.969,-67.976 0,-37.531 27.52,-67.559 63.801,-67.559 37.949,0 63.387,30.028 63.387,67.559 z m -177.652,17.097 c 0,68.391 7.925,137.2 87.992,153.887 l 120.101,25.02 8.34,-40.45 -120.101,-26.277 c -42.536,-9.172 -55.461,-33.359 -57.961,-62.551 11.257,19.18 38.781,41.282 84.652,41.282 56.715,0 105.094,-46.7 105.094,-107.168 0,-60.891 -48.379,-112.18 -114.684,-112.18 -71.312,0 -113.433,47.117 -113.433,128.437" id="path40" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 1171.31,792.781 c -3.33,32.52 -22.52,57.961 -55.88,57.961 -30.86,0 -52.54,-23.769 -57.13,-57.961 z m -163.05,-15.429 c 0,62.968 44.62,114.679 107.59,114.679 70.06,0 105.51,-55.051 105.51,-118.437 0,-3.332 -0.42,-11.672 -0.84,-14.18 h -161.8 c 5.42,-35.859 30.86,-55.879 63.38,-55.879 24.61,0 42.12,9.18 59.64,26.27 l 29.61,-26.27 c -20.85,-25.019 -49.63,-41.281 -90.08,-41.281 -63.8,0 -113.01,46.289 -113.01,115.098" id="path42" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 1260.14,776.102 v 0.832 c 0,62.546 48.38,115.097 114.26,115.097 41.71,0 67.56,-15.429 88,-37.949 l -31.28,-33.781 c -15.43,16.262 -31.69,27.519 -57.13,27.519 -36.7,0 -63.39,-31.687 -63.39,-70.058 v -0.828 c 0,-39.2 27.11,-70.899 65.89,-70.899 23.77,0 41.29,11.258 57.13,27.528 l 30.45,-30.028 c -21.69,-24.191 -47.13,-41.281 -90.08,-41.281 -65.47,0 -113.85,51.289 -113.85,113.848" id="path44" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 1508.28,887.441 h 50.46 v -89.238 h 97.16 v 89.238 h 50.46 V 667.254 h -50.46 v 88.828 h -97.16 v -88.828 h -50.46 v 220.187" id="path46" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 1905.71,759.414 c -12.93,5.008 -30.86,8.758 -50.46,8.758 -31.7,0 -50.46,-12.93 -50.46,-35.027 0,-20.852 18.76,-32.532 42.53,-32.532 33.37,0 58.39,18.77 58.39,46.289 z m -1.25,-92.16 v 27.109 c -15.02,-17.937 -37.95,-31.699 -71.31,-31.699 -41.7,0 -78.4,23.77 -78.4,68.809 0,48.8 37.95,72.148 89.24,72.148 26.69,0 43.79,-3.75 60.88,-9.18 v 4.172 c 0,30.45 -19.18,47.129 -54.21,47.129 -24.6,0 -42.95,-5.422 -62.97,-13.762 l -13.76,40.45 c 24.19,10.84 47.96,18.351 83.82,18.351 65.06,0 96.75,-34.199 96.75,-93 V 667.254 h -50.04" id="path48" style="fill:#c92530;fill-opacity:1;fill-rule:nonzero;stroke:none"></path><path d="m 455.633,1292.34 c 701.397,493.9 1988.587,321.82 2510.557,-637.485 h 113.27 C 2533.19,1667.42 1170.09,1831.41 455.633,1292.34 Z M 145.844,921.262 c -7.18,-9.559 -14.219,-19.282 -21.059,-29.149 -0.371,-0.508 -0.672,-1.039 -1.035,-1.547 0.645,0.895 1.23,1.813 1.883,2.704 38.222,54.796 81.43,104.617 128.847,149.13 4.184,4.86 8.547,9.52 12.813,14.29 -44.445,-40.54 -85.16,-85.577 -121.375,-135.323 -0.023,-0.035 -0.051,-0.07 -0.074,-0.105" id="path50" style="fill:#c92530;fill-opacity:1;fill-rule:evenodd;stroke:none"></path><path d="m 222.801,1011.3 c 7.875,8.93 15.929,17.65 24.101,26.24 -36.261,-35.16 -69.812,-73.517 -100.218,-115.165 23.742,31.414 49.144,61.113 76.117,88.925 z M 131.969,929.629 C 638.711,1701.26 2135.7,1670.23 2688.27,654.855 h 147.76 C 2246.07,1740.84 642.297,1765.98 131.969,929.629 Z m -7.871,-38.492 c 1.75,2.523 3.578,4.965 5.351,7.465 -1.586,-2.239 -3.242,-4.399 -4.812,-6.657 -0.192,-0.261 -0.348,-0.543 -0.539,-0.808" id="path52" style="fill:#c92530;fill-opacity:1;fill-rule:evenodd;stroke:none"></path><path d="M 2291.13,654.852 C 1848.11,1506.8 353.984,1534.27 4.39453,654.852 H 0 c 276.23,932.888 1932.65,1031.088 2509.17,0 h -218.04" id="path54" style="fill:#c92530;fill-opacity:1;fill-rule:evenodd;stroke:none"></path></g></g></g></g></svg>
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://cdn.britannica.com/73/6073-004-B0B9EBEE/Flag-Austria.jpg" alt="" height="60">
            </div>
            <div class="col-12 col-md d-flex align-items-center bg-light p-5 justify-content-center m-1">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Flag_of_the_People%27s_Republic_of_China.svg/1200px-Flag_of_the_People%27s_Republic_of_China.svg.png" alt="" height="60">
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
