<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-lg">
        <a class="navbar-brand d-flex" href="{{ url('/') }}">
            <svg class="bi bi-intersect mr-3 text-primary" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12 4v6.5a1.5 1.5 0 0 1-1.5 1.5H4V5.5A1.5 1.5 0 0 1 5.5 4H12z"/>
                <path fill-rule="evenodd" d="M14.5 5h-9a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-9-1A1.5 1.5 0 0 0 4 5.5v9A1.5 1.5 0 0 0 5.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 4h-9z"/>
                <path fill-rule="evenodd" d="M10.5 1h-9a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-9-1A1.5 1.5 0 0 0 0 1.5v9A1.5 1.5 0 0 0 1.5 12h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 10.5 0h-9z"/>
            </svg>
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto d-md-none">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <svg class="bi bi-pie-chart mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M7.5 7.793V1h1v6.5H15v1H8.207l-4.853 4.854-.708-.708L7.5 7.793z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('dashboard.title') }} <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}">
                        <svg class="bi bi-tag mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M.5 2A1.5 1.5 0 012 .5h4.586a1.5 1.5 0 011.06.44l7 7a1.5 1.5 0 010 2.12l-4.585 4.586a1.5 1.5 0 01-2.122 0l-7-7A1.5 1.5 0 01.5 6.586V2zM2 1.5a.5.5 0 00-.5.5v4.586a.5.5 0 00.146.353l7 7a.5.5 0 00.708 0l4.585-4.585a.5.5 0 000-.708l-7-7a.5.5 0 00-.353-.146H2z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M2.5 4.5a2 2 0 114 0 2 2 0 01-4 0zm2-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('product.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <svg class="bi bi-bucket mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 1.5A4.5 4.5 0 003.5 6h-1a5.5 5.5 0 1111 0h-1A4.5 4.5 0 008 1.5z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M1.61 5.687A.5.5 0 012 5.5h12a.5.5 0 01.488.608l-1.826 8.217a1.5 1.5 0 01-1.464 1.175H4.802a1.5 1.5 0 01-1.464-1.175L1.512 6.108a.5.5 0 01.098-.42zm1.013.813l1.691 7.608a.5.5 0 00.488.392h6.396a.5.5 0 00.488-.392l1.69-7.608H2.624z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('order.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.customers.index') }}">
                        <svg class="bi bi-people mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 00.014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 00.022.004zm7.973.056v-.002.002zM11 7a2 2 0 100-4 2 2 0 000 4zm3-2a3 3 0 11-6 0 3 3 0 016 0zM6.936 9.28a5.88 5.88 0 00-1.23-.247A7.35 7.35 0 005 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 015 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 116 0 3 3 0 01-6 0zm3-2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('customer.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">
                        <svg class="bi bi-list-task mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2 2.5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5V3a.5.5 0 00-.5-.5H2zM3 3H2v1h1V3z" clip-rule="evenodd"/>
                            <path d="M5 3.5a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zM5.5 7a.5.5 0 000 1h9a.5.5 0 000-1h-9zm0 4a.5.5 0 000 1h9a.5.5 0 000-1h-9z"/>
                            <path fill-rule="evenodd" d="M1.5 7a.5.5 0 01.5-.5h1a.5.5 0 01.5.5v1a.5.5 0 01-.5.5H2a.5.5 0 01-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5H2zm1 .5H2v1h1v-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('category.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.brands.index') }}">
                        <svg class="bi bi-briefcase mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 12.5A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-6h-1v6a.5.5 0 01-.5.5h-13a.5.5 0 01-.5-.5v-6H0v6z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M0 4.5A1.5 1.5 0 011.5 3h13A1.5 1.5 0 0116 4.5v2.384l-7.614 2.03a1.5 1.5 0 01-.772 0L0 6.884V4.5zM1.5 4a.5.5 0 00-.5.5v1.616l6.871 1.832a.5.5 0 00.258 0L15 6.116V4.5a.5.5 0 00-.5-.5h-13zM5 2.5A1.5 1.5 0 016.5 1h3A1.5 1.5 0 0111 2.5V3h-1v-.5a.5.5 0 00-.5-.5h-3a.5.5 0 00-.5.5V3H5v-.5z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('brand.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.attributes.index') }}">
                        <svg class="bi bi-puzzle mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.605 2.5V2v.5zM3.61 3.6l.498-.043V3.55l-.498.05zM7 2.5h.5A.5.5 0 007 2v.5zm-.676 1.454l.304.397-.304-.397zm3.352 0l-.304.397.304-.397zM9 2.5V2a.5.5 0 00-.5.5H9zm3.39 1.1l-.498-.05v.007l.498.043zM12.1 7l-.498-.043a.5.5 0 00.498.543V7zm1.854-.676l.397.304-.397-.304zm0 3.352l.397-.304-.397.304zM12.1 9v-.5a.5.5 0 00-.498.542L12.1 9zm.29 3.4l-.498.043v.007l.498-.05zM9 13.5h-.5a.5.5 0 00.5.5v-.5zm.676-1.454l-.304-.397.304.397zm-3.352 0l.304-.397-.304.397zM7 13.5v.5a.5.5 0 00.5-.5H7zm-2.395 0V13v.5zm-.995-1.1l.498.05v-.007L3.61 12.4zM3.9 9l.498.042A.5.5 0 003.9 8.5V9zm-1.854.676l-.397-.304.397.304zm0-3.352l-.397.304.397-.304zM3.9 7v.5a.5.5 0 00.498-.543L3.9 7zm.705-5a1.5 1.5 0 00-1.493 1.65l.995-.1A.5.5 0 014.605 3V2zM7 2H4.605v1H7V2zm.5.882V2.5h-1v.382h1zm-.872 1.469c.375-.287.872-.773.872-1.469h-1c0 .195-.147.42-.48.675l.608.794zM6.5 4.5l.001-.006a.113.113 0 01.012-.025.459.459 0 01.115-.118l-.608-.794c-.274.21-.52.528-.52.943h1zM8 5c-.491 0-.912-.1-1.19-.24a.86.86 0 01-.271-.194.213.213 0 01-.039-.063V4.5h-1c0 .568.447.947.862 1.154C6.807 5.877 7.387 6 8 6V5zm1.5-.5v.003a.213.213 0 01-.039.064.86.86 0 01-.27.193C8.91 4.9 8.49 5 8 5v1c.613 0 1.193-.123 1.638-.346.415-.207.862-.586.862-1.154h-1zm-.128-.15c.065.05.099.092.115.119.008.013.01.021.012.025L9.5 4.5h1c0-.415-.246-.733-.52-.943l-.608.794zM8.5 2.883c0 .696.497 1.182.872 1.469l.608-.794c-.333-.255-.48-.48-.48-.675h-1zm0-.382v.382h1V2.5h-1zm2.895-.5H9v1h2.395V2zm1.493 1.65A1.5 1.5 0 0011.395 2v1a.5.5 0 01.498.55l.995.1zm-.29 3.392l.29-3.4-.996-.085-.29 3.4.996.085zm.284-.542H12.1v1h.782v-1zm.675-.48c-.255.333-.48.48-.675.48v1c.696 0 1.182-.497 1.469-.872l-.794-.608zm.943-.52c-.415 0-.733.246-.943.52l.794.608a.459.459 0 01.118-.115.113.113 0 01.025-.012L14.5 6.5v-1zM16 8c0-.613-.123-1.193-.346-1.638-.207-.415-.586-.862-1.154-.862v1h.003l.01.003a.237.237 0 01.053.036.86.86 0 01.194.27c.14.28.24.7.24 1.191h1zm-1.5 2.5c.568 0 .947-.447 1.154-.862C15.877 9.193 16 8.613 16 8h-1c0 .491-.1.912-.24 1.19a.86.86 0 01-.194.271.214.214 0 01-.063.039H14.5v1zm-.943-.52c.21.274.528.52.943.52v-1l-.006-.001a.113.113 0 01-.025-.012.458.458 0 01-.118-.115l-.794.608zm-.675-.48c.195 0 .42.147.675.48l.794-.608c-.287-.375-.773-.872-1.469-.872v1zm-.782 0h.782v-1H12.1v1zm.788 2.858l-.29-3.4-.996.084.29 3.401.996-.085zM11.395 14a1.5 1.5 0 001.493-1.65l-.995.1a.5.5 0 01-.498.55v1zM9 14h2.395v-1H9v1zm.5-.5v-.382h-1v.382h1zm0-.382c0-.195.147-.42.48-.675l-.608-.794c-.375.287-.872.773-.872 1.469h1zm.48-.675c.274-.21.52-.528.52-.943h-1l-.001.006a.113.113 0 01-.012.025.459.459 0 01-.115.118l.608.794zm.52-.943c0-.568-.447-.947-.862-1.154C9.193 10.123 8.613 10 8 10v1c.492 0 .912.1 1.19.24.14.07.226.14.271.194a.214.214 0 01.039.063v.003h1zM8 10c-.613 0-1.193.123-1.638.346-.415.207-.862.586-.862 1.154h1v-.003l.003-.01a.214.214 0 01.036-.053.859.859 0 01.27-.194C7.09 11.1 7.51 11 8 11v-1zm-2.5 1.5c0 .415.246.733.52.943l.608-.794a.459.459 0 01-.115-.118.113.113 0 01-.012-.025L6.5 11.5h-1zm.52.943c.333.255.48.48.48.675h1c0-.696-.497-1.182-.872-1.469l-.608.794zm.48.675v.382h1v-.382h-1zM4.605 14H7v-1H4.605v1zm-1.493-1.65A1.5 1.5 0 004.605 14v-1a.5.5 0 01-.498-.55l-.995-.1zm.29-3.393l-.29 3.401.996.085.29-3.4-.996-.086zm-.284.543H3.9v-1h-.782v1zm-.675.48c.255-.333.48-.48.675-.48v-1c-.696 0-1.182.497-1.469.872l.794.608zm-.943.52c.415 0 .733-.246.943-.52l-.794-.608a.459.459 0 01-.118.115.112.112 0 01-.025.012L1.5 9.5v1zM0 8c0 .613.123 1.193.346 1.638.207.415.586.862 1.154.862v-1h-.003a.213.213 0 01-.064-.039.86.86 0 01-.193-.27C1.1 8.91 1 8.49 1 8H0zm1.5-2.5c-.568 0-.947.447-1.154.862C.123 6.807 0 7.387 0 8h1c0-.492.1-.912.24-1.19a.86.86 0 01.194-.271.213.213 0 01.063-.039H1.5v-1zm.943.52c-.21-.274-.528-.52-.943-.52v1l.006.001a.112.112 0 01.025.012c.027.016.068.05.118.115l.794-.608zm.675.48c-.195 0-.42-.147-.675-.48l-.794.608c.287.375.773.872 1.469.872v-1zm.782 0h-.782v1H3.9v-1zm-.788-2.858l.29 3.4.996-.085-.29-3.4-.996.085z"/>
                        </svg>
                        {{ __('attribute.plural') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.images.index') }}">
                        <svg class="bi bi-image mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14.002 2h-12a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm-12-1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12z"/>
                            <path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V14h-14v-2l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
                            <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                        </svg>
                        {{ __('common.images') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <svg class="bi bi-person-check mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm6.854.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        {{ __('user.plural') }}
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">{{ __('auth.login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.users.edit', Auth::user()) }}">
                                <svg class="bi bi-gear mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 014.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 01-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 011.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 012.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 012.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 011.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 01-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 018.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 001.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 00.52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 00-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 00-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 00-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 00-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 00.52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 001.255-.52l.094-.319z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 100 4.492 2.246 2.246 0 000-4.492zM4.754 8a3.246 3.246 0 116.492 0 3.246 3.246 0 01-6.492 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('common.settings') }}
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <svg class="bi bi-box-arrow-right mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 010-.708L14.293 8l-2.647-2.646a.5.5 0 01.708-.708l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708 0z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M4.5 8a.5.5 0 01.5-.5h9a.5.5 0 010 1H5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 01.5 12V4A1.5 1.5 0 012 2.5h7A1.5 1.5 0 0110.5 4v1.5a.5.5 0 01-1 0V4a.5.5 0 00-.5-.5H2a.5.5 0 00-.5.5v8a.5.5 0 00.5.5h7a.5.5 0 00.5-.5v-1.5a.5.5 0 011 0V12A1.5 1.5 0 019 13.5H2z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('auth.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>