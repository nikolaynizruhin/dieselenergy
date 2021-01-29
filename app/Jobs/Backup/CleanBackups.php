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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $storage = Storage::disk('local');

        $backups = $storage->files(config('backup.backups'));

        foreach ($backups as $backup) {
            if (! Str::endsWith($backup, '.zip')) {
                continue;
            }

            $modifiedAt = Carbon::createFromTimestamp($storage->lastModified($backup));

            if (now()->diffInDays($modifiedAt) <= config('backup.lifetime')) {
                continue;
            }

            $storage->delete($backup);
        }
    }
}
