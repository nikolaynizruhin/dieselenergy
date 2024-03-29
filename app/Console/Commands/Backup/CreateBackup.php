<?php

namespace App\Console\Commands\Backup;

use App\Jobs\Backup\CreateBackup as CreateBackupJob;
use Illuminate\Console\Command;

class CreateBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database and images';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        CreateBackupJob::dispatch();

        $this->info('Backup created successfully!');

        return self::SUCCESS;
    }
}
