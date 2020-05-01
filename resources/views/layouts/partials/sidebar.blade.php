<ul class="nav flex-column d-none d-md-flex">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#">
            <svg class="bi bi-pie-chart mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 15A7 7 0 108 1a7 7 0 000 14zm0 1A8 8 0 108 0a8 8 0 000 16z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M7.5 7.793V1h1v6.5H15v1H8.207l-4.853 4.854-.708-.708L7.5 7.793z" clip-rule="evenodd"/>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="{{ route('products.index') }}">
            <svg class="bi bi-tag mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M.5 2A1.5 1.5 0 012 .5h4.586a1.5 1.5 0 011.06.44l7 7a1.5 1.5 0 010 2.12l-4.585 4.586a1.5 1.5 0 01-2.122 0l-7-7A1.5 1.5 0 01.5 6.586V2zM2 1.5a.5.5 0 00-.5.5v4.586a.5.5 0 00.146.353l7 7a.5.5 0 00.708 0l4.585-4.585a.5.5 0 000-.708l-7-7a.5.5 0 00-.353-.146H2z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M2.5 4.5a2 2 0 114 0 2 2 0 01-4 0zm2-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
            </svg>
            {{ __('Products') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#">
            <svg class="bi bi-bucket mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 1.5A4.5 4.5 0 003.5 6h-1a5.5 5.5 0 1111 0h-1A4.5 4.5 0 008 1.5z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M1.61 5.687A.5.5 0 012 5.5h12a.5.5 0 01.488.608l-1.826 8.217a1.5 1.5 0 01-1.464 1.175H4.802a1.5 1.5 0 01-1.464-1.175L1.512 6.108a.5.5 0 01.098-.42zm1.013.813l1.691 7.608a.5.5 0 00.488.392h6.396a.5.5 0 00.488-.392l1.69-7.608H2.624z" clip-rule="evenodd"/>
            </svg>
            {{ __('Orders') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (request()->is('users')) active @endif d-flex align-items-center" href="{{ route('users.index') }}">
            <svg class="bi bi-people mr-2" width="1.1em" height="1.1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 00.014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 00.022.004zm7.973.056v-.002.002zM11 7a2 2 0 100-4 2 2 0 000 4zm3-2a3 3 0 11-6 0 3 3 0 016 0zM6.936 9.28a5.88 5.88 0 00-1.23-.247A7.35 7.35 0 005 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 015 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 116 0 3 3 0 01-6 0zm3-2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"/>
            </svg>
            {{ __('Users') }}
        </a>
    </li>
</ul>
