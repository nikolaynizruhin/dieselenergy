<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('local');

    $this->backup = UploadedFile::fake()
        ->create('backup.zip')
        ->storeAs(config('backup.folder'), 'backup.zip', 'local');
});

it('can clean backups older than a week', function () {
    $this->travel(config('backup.lifetime'))->days();

    $this->artisan('backup:clean')
        ->expectsOutput('Backups cleaned successfully!')
        ->assertSuccessful();

    Storage::disk('local')->assertMissing($this->backup);
});

it('can should not clean backups less than a week', function () {
    $this->artisan('backup:clean')
        ->expectsOutput('Backups cleaned successfully!')
        ->assertSuccessful();

    Storage::disk('local')->assertExists($this->backup);
});
