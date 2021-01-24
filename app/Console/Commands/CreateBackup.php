<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
    protected $description = 'Backup images';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $zip = new ZipArchive();

        $zip->open(config('backup.destination'), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $images = File::files(config('backup.source'));

        foreach ($images as $image) {
            $zip->addFile($image->getPathname(), 'images/'.$image->getFilename());
        }

        $zip->close();

        $this->info('Backup created successfully!');

        return 0;
    }
}
