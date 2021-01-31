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
     * Clean backups job.
     *
     * @var \App\Jobs\Backup\CleanBackups
     */
    private $cleanBackups;

    /**
     * CleanBackups constructor.
     *
     * @param  \App\Jobs\Backup\CleanBackups  $cleanBackups
     */
    public function __construct(CleanBackupsJob $cleanBackups)
    {
        parent::__construct();

        $this->cleanBackups = $cleanBackups;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch($this->cleanBackups);

        $this->info('Backups cleaned successfully!');

        return 0;
    }
}
