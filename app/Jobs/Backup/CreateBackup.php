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
        $zip = new ZipArchive;

        $zip->open($this->filename(), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->backupImages($zip);

        $this->backupDatabase($zip);

        $zip->close();

        $this->cleanup();
    }

    /**
     * Backup images.
     *
     * @param  \ZipArchive  $zip
     */
    private function backupImages($zip)
    {
        foreach ($this->images() as $image) {
            $zip->addFile(Storage::disk('local')->path($image), ltrim($image, 'public'));
        }
    }

    /**
     * Backup database.
     *
     * @param  \ZipArchive  $zip
     */
    private function backupDatabase($zip)
    {
        Dumper::dump(Storage::disk('local')->path(config('backup.database')));

        $zip->addFile(Storage::disk('local')->path(config('backup.database')), 'database.sql');
    }

    /**
     * Cleanup temporary files.
     */
    private function cleanup()
    {
        Storage::disk('local')->delete(config('backup.database'));
    }

    /**
     * Get backup filename.
     *
     * @return string
     */
    private function filename()
    {
        return Storage::disk('local')->path($this->file());
    }

    /**
     * Get backup file.
     *
     * @return string
     */
    private function file()
    {
        return config('backup.folder').'/'.date(config('backup.format')).'.zip';
    }

    /**
     * Get images.
     *
     * @return array
     */
    private function images()
    {
        return Storage::disk('local')->files(config('backup.files'));
    }
}
