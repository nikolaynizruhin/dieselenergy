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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $backups = Storage::disk('local')->files(config('backup.backups'));

        collect($backups)
            ->filter(fn ($backup) => Str::endsWith($backup, '.zip'))
            ->filter(function ($backup) {
                $changedAt = Carbon::createFromTimestamp(Storage::disk('local')->lastModified($backup));

                return now()->diffInDays($changedAt) > config('backup.lifetime');
            })->each(fn ($backup) => Storage::disk('local')->delete($backup));

        $this->info('Backups cleaned successfully!');

        return 0;
    }
}
