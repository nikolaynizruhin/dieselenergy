<?php

namespace App\Console\Commands\Backup;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CleanBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old backups';

    /**
     * Local storage.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    private $storage;

    public function __construct()
    {
        parent::__construct();

        $this->storage = Storage::disk('local');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $backups = $this->storage->files(config('backup.backups'));

        collect($backups)
            ->filter(fn ($backup) => Str::endsWith($backup, '.zip'))
            ->filter(function ($backup) {
                $timestamp = $this->storage->lastModified($backup);
                $modifiedAt = Carbon::createFromTimestamp($timestamp);

                return now()->diffInDays($modifiedAt) > config('backup.lifetime');
            })->each(fn ($backup) => $this->storage->delete($backup));

        $this->info('Backups cleaned successfully!');

        return 0;
    }
}
