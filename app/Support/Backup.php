<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Backup
{
    /**
     * Backup construct.
     *
     * @param  string  $path
     */
    public function __construct(readonly private string $path)
    {
    }

    /**
     * Get all backups.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all(): Collection
    {
        $backups = Storage::disk('local')->files(config('backup.folder'));

        return collect($backups)
            ->filter(fn ($backup) => Str::endsWith($backup, '.zip'))
            ->map(fn ($backup) => new Backup($backup));
    }

    /**
     * Check if backup is outdated.
     *
     * @return bool
     */
    public function isOutdated(): bool
    {
        $timestamp = Storage::disk('local')->lastModified($this->path);

        $modifiedAt = Carbon::createFromTimestamp($timestamp);

        return now()->diffInDays($modifiedAt) >= config('backup.lifetime');
    }

    /**
     * Delete backup.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return Storage::disk('local')->delete($this->path);
    }
}
