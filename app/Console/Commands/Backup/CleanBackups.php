<?php

namespace App\Console\Commands\Backup;

use App\Jobs\Backup\CleanBackups as CleanBackupsJob;
use Illuminate\Console\Command;

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
    public function handle(): int
    {
        CleanBackupsJob::dispatch();

        $this->info('Backups cleaned successfully!');

        return self::SUCCESS;
    }
}
