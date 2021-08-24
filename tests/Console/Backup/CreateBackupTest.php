<?php

namespace Tests\Console\Backup;

use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateBackupTest extends TestCase
{
    /** @test */
    public function it_can_backup_database_and_images()
    {
        Storage::fake('local');

        Storage::disk('local')
            ->makeDirectory(config('backup.folder'));

        UploadedFile::fake()
            ->image('product.jpg')
            ->store('public/images', 'local');

        $this->artisan('backup:create')
            ->expectsOutput('Backup created successfully!')
            ->assertExitCode(Command::SUCCESS);

        Storage::disk('local')
            ->assertExists(config('backup.folder').'/'.date(config('backup.format')).'.zip');
    }
}
