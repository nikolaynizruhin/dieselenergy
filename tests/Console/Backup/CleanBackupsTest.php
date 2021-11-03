<?php

namespace Tests\Console\Backup;

use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanBackupsTest extends TestCase
{
    /**
     * Backup path.
     *
     * @var string
     */
    private $backup;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->backup = UploadedFile::fake()
            ->create('backup.zip')
            ->storeAs(config('backup.folder'), 'backup.zip', 'local');
    }

    /** @test */
    public function it_can_clean_backups_older_than_a_week()
    {
        $this->travel(config('backup.lifetime'))->days();

        $this->artisan('backup:clean')
            ->expectsOutput('Backups cleaned successfully!')
            ->assertSuccessful();

        Storage::disk('local')->assertMissing($this->backup);
    }

    /** @test */
    public function it_can_should_not_clean_backups_less_than_a_week()
    {
        $this->artisan('backup:clean')
            ->expectsOutput('Backups cleaned successfully!')
            ->assertSuccessful();

        Storage::disk('local')->assertExists($this->backup);
    }
}
