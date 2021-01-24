<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backup Destination File
    |--------------------------------------------------------------------------
    |
    | This option controls the backup destination filename.
    |
    */

    'destination' => storage_path('app/backups/'.date('Ymd').'.zip'),

    /*
    |--------------------------------------------------------------------------
    | Backup Source Folder
    |--------------------------------------------------------------------------
    |
    | This option controls the backup source folder path.
    |
    */

    'source' => storage_path('app/public/images'),

];
