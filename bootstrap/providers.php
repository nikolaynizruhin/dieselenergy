<?php

use App\Providers\AppServiceProvider;
use App\Providers\DirectiveServiceProvider;
use App\Providers\DumpServiceProvider;
use App\Providers\PaginatorServiceProvider;
use App\Providers\ViewServiceProvider;

return [
    AppServiceProvider::class,
    DirectiveServiceProvider::class,
    DumpServiceProvider::class,
    PaginatorServiceProvider::class,
    ViewServiceProvider::class,
];
