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

    'filename' => 'backups/'.date('Ymd').'.zip',

    /*
    |--------------------------------------------------------------------------
    | Backup Database Path
    |--------------------------------------------------------------------------
    |
    | This option controls the backup database path.
    |
    */

    'database' => 'backup.sql',

    /*
    |--------------------------------------------------------------------------
    | Backup Files Folder
    |--------------------------------------------------------------------------
    |
    | This option controls the backup source folder path.
    |
    */

    'files' => 'public/images',

    /*
    |--------------------------------------------------------------------------
    | Backups Folder
    |--------------------------------------------------------------------------
    |
    | This option controls the backups source folder path.
    |
    */

    'folder' => 'backups',

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
