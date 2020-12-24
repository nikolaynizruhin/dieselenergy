<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Field Name
    |--------------------------------------------------------------------------
    |
    | Field name for honeypot hidden input.
    |
    */

    'field' => 'honeypot',

    /*
    |--------------------------------------------------------------------------
    | Valid From Field Name
    |--------------------------------------------------------------------------
    |
    | Valid from field name for honeypot hidden input.
    |
    */

    'valid_from_field' => 'valid_from',

    /*
    |--------------------------------------------------------------------------
    | Amount Of Seconds
    |--------------------------------------------------------------------------
    |
    | If the form is submitted faster than this amount of seconds
    | the form submission will be considered invalid.
    |
    */

    'seconds' => 3,

];
