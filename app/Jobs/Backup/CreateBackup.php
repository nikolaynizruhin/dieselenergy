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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new ZipArchive();

        $storage = Storage::disk('local');

        $zip->open($storage->path(config('backup.filename')), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $images = $storage->files(config('backup.files'));

        foreach ($images as $image) {
            $zip->addFile($storage->path($image), $image);
        }

        Dumper::dump($storage->path(config('backup.database')));

        $zip->addFile($storage->path(config('backup.database')), 'database.sql');

        $zip->close();

        $storage->delete(config('backup.database'));
    }
}
