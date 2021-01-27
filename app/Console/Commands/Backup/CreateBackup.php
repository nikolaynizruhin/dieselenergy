<?php

namespace App\Console\Commands\Backup;

use Facades\App\Dump\Dumper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
     *
     * @return int
     */
    public function handle()
    {
        $zip = new ZipArchive();

        $zip->open(Storage::disk('local')->path(config('backup.filename')), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $images = Storage::disk('local')->files(config('backup.files'));

        foreach ($images as $image) {
            $zip->addFile(Storage::disk('local')->path($image), $image);
        }

        Dumper::dump(Storage::disk('local')->path(config('backup.database')));

        $zip->addFile(Storage::disk('local')->path(config('backup.database')), 'database.sql');

        $zip->close();

        Storage::disk('local')->delete(config('backup.database'));

        $this->info('Backup created successfully!');

        return 0;
    }
}
