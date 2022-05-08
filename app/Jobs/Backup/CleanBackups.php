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
        foreach ($this->backups() as $backup) {
            if ($this->canBeRemoved($backup)) {
                Storage::disk('local')->delete($backup);
            }
        }
    }

    /**
     * Check if backup can be removed.
     *
     * @param  string $backup
     * @return bool
     */
    private function canBeRemoved(string $backup): bool
    {
        return Str::endsWith($backup, '.zip') && $this->isOutdated($backup);
    }

    /**
     * Check if backup is outdated.
     *
     * @param  string $backup
     * @return bool
     */
    private function isOutdated(string $backup): bool
    {
        $timestamp = Storage::disk('local')->lastModified($backup);

        $modifiedAt = Carbon::createFromTimestamp($timestamp);

        return now()->diffInDays($modifiedAt) >= config('backup.lifetime');
    }

    /**
     * Get list of backups.
     *
     * @return array
     */
    private function backups(): array
    {
        return Storage::disk('local')->files(config('backup.folder'));
    }
}
