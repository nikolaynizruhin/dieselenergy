<?php

namespace Tests\Console;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateBackupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'backup.filename' => storage_path('framework/testing/disks/public/backup.zip'),
            'backup.files' => storage_path('framework/testing/disks/public/images'),
        ]);
    }

    /** @test */
    public function it_can_backup_database_and_images()
    {
        Storage::fake();

        UploadedFile::fake()->image('product.jpg')->store('images');

        $this->artisan('backup:create')
            ->expectsOutput('Backup created successfully!')
            ->assertExitCode(0);

        Storage::assertExists('backup.zip');
    }
}
