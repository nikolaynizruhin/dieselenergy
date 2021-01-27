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

        config(['backup.filename' => 'backup.zip']);
    }

    /** @test */
    public function it_can_backup_database_and_images()
    {
        Storage::fake('local');

        UploadedFile::fake()->image('product.jpg')->store('public/images', 'local');

        $this->artisan('backup:create')
            ->expectsOutput('Backup created successfully!')
            ->assertExitCode(0);

        Storage::disk('local')->assertExists('backup.zip');
    }
}
