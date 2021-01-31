<?php

namespace App\Jobs\Backup;

use Facades\App\Dump\Dumper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CreateBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Local storage.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $storage;

    /**
     * Zip archive.
     *
     * @var \ZipArchive
     */
    private $zip;

    public function __construct()
    {
        $this->zip = new ZipArchive();
        $this->storage = Storage::disk('local');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->zip->open($this->filename(), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->backupImages();

        $this->backupDatabase();

        $this->zip->close();

        $this->cleanup();
    }

    /**
     * Backup images.
     */
    private function backupImages()
    {
        foreach ($this->images() as $image) {
            $this->zip->addFile($this->storage->path($image), ltrim($image, 'public'));
        }
    }

    /**
     * Backup database.
     */
    private function backupDatabase()
    {
        Dumper::dump($this->storage->path(config('backup.database')));

        $this->zip->addFile($this->storage->path(config('backup.database')), 'database.sql');
    }

    /**
     * Cleanup temporary files.
     */
    private function cleanup()
    {
        $this->storage->delete(config('backup.database'));
    }

    /**
     * Get backup filename.
     *
     * @return string
     */
    private function filename()
    {
        return $this->storage->path(config('backup.filename'));
    }

    /**
     * Get images.
     *
     * @return array
     */
    private function images()
    {
        return $this->storage->files(config('backup.files'));
    }
}
