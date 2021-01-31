<?php

namespace App\Jobs\Backup;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CleanBackups implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Local storage.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $storage;

    /**
     * Command constructor.
     *
     * @param  \Illuminate\Filesystem\FilesystemManager
     */
    public function __construct(FilesystemManager $storage)
    {
        $this->storage = $storage->disk('local');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->backups() as $backup) {
            if ($this->canBeRemoved($backup)) {
                $this->storage->delete($backup);
            }
        }
    }

    /**
     * Check if backup can be removed.
     *
     * @param  string  $backup
     * @return bool
     */
    private function canBeRemoved($backup)
    {
        if (! Str::endsWith($backup, '.zip')) {
            return false;
        }

        $timestamp = $this->storage->lastModified($backup);

        $modifiedAt = Carbon::createFromTimestamp($timestamp);

        return now()->diffInDays($modifiedAt) > config('backup.lifetime');
    }

    /**
     * Get list of backups.
     *
     * @return array
     */
    private function backups()
    {
        return $this->storage->files(config('backup.backups'));
    }
}
