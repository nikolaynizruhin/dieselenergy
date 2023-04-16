<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can backup database and images', function () {
    Storage::fake('local');

    Storage::disk('local')
        ->makeDirectory(config('backup.folder'));

    UploadedFile::fake()
        ->image('product.jpg')
        ->store('public/images', 'local');

    $this->artisan('backup:create')
        ->expectsOutput('Backup created successfully!')
        ->assertSuccessful();

    Storage::disk('local')
        ->assertExists(config('backup.folder').'/'.date(config('backup.format')).'.zip');
});
