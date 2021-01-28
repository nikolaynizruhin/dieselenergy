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
     * @var \Illuminate\Support\Facades\Storage
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
        $this->zip->open(
            $this->storage->path(config('backup.filename')),
            ZipArchive::CREATE | ZipArchive::OVERWRITE,
        );

        $images = $this->storage->files(config('backup.files'));

        foreach ($images as $image) {
            $this->zip->addFile($this->storage->path($image), $image);
        }

        Dumper::dump($this->storage->path(config('backup.database')));

        $this->zip->addFile($this->storage->path(config('backup.database')), 'database.sql');

        $this->zip->close();

        $this->storage->delete(config('backup.database'));
    }
}
