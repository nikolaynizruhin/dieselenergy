<?php

namespace App\Jobs\Backup;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CleanBackups implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Local storage.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    private $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('local');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $backups = $this->storage->files(config('backup.backups'));

        collect($backups)->filter(function ($backup) {
            if (! Str::endsWith($backup, '.zip')) {
                return false;
            }

            $timestamp = $this->storage->lastModified($backup);
            $modifiedAt = Carbon::createFromTimestamp($timestamp);

            return now()->diffInDays($modifiedAt) > config('backup.lifetime');
        })->each(fn ($backup) => $this->storage->delete($backup));
    }
}
