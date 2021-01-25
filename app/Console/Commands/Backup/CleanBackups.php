<?php

namespace App\Console\Commands\Backup;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

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
        $backups = File::files(config('backup.backups'));

        collect($backups)
            ->filter(function ($backup) {
                $changedAt = Carbon::createFromTimestamp($backup->getCTime());

                return now()->diffInDays($changedAt) > config('backup.lifetime');
            })->each(fn ($backup) => unlink($backup->getPathname()));

        $this->info('Backups cleaned successfully!');

        return 0;
    }
}
