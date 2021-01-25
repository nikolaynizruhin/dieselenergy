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

    'filename' => storage_path('app/backups/'.date('Ymd').'.zip'),

    /*
    |--------------------------------------------------------------------------
    | Backup Database Path
    |--------------------------------------------------------------------------
    |
    | This option controls the backup database path.
    |
    */

    'database' => database_path('backup.sql'),

    /*
    |--------------------------------------------------------------------------
    | Backup Files Folder
    |--------------------------------------------------------------------------
    |
    | This option controls the backup source folder path.
    |
    */

    'files' => storage_path('app/public/images'),

    /*
    |--------------------------------------------------------------------------
    | Backups Folder
    |--------------------------------------------------------------------------
    |
    | This option controls the backups source folder path.
    |
    */

    'backups' => storage_path('app/backups'),

    /*
    |--------------------------------------------------------------------------
    | Backups Lifetime
    |--------------------------------------------------------------------------
    |
    | This option controls the backups lifetime in days.
    |
    */

    'lifetime' => 7,

];
