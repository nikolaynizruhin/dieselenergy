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
     */
    public function __construct(readonly private string $path)
    {
    }

    /**
     * Get all backups.
     */
    public static function all(): Collection
    {
        $backups = Storage::disk('local')->files(config('backup.folder'));

        return collect($backups)
            ->filter(fn ($backup) => Str::endsWith($backup, '.zip'))
            ->map(fn ($backup) => new Backup($backup));
    }

    /**
     * Get outdated backups.
     */
    public static function outdated(): Collection
    {
        return static::all()->filter->isOutdated();
    }

    /**
     * Check if backup is outdated.
     */
    public function isOutdated(): bool
    {
        $timestamp = Storage::disk('local')->lastModified($this->path);

        return Carbon::createFromTimestamp($timestamp)
            ->addDays(config('backup.lifetime'))
            ->isPast();
    }

    /**
     * Delete backup.
     */
    public function delete(): bool
    {
        return Storage::disk('local')->delete($this->path);
    }
}
