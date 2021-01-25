<?php

namespace App\Console\Commands\Backup;

use Facades\App\Dump\Dumper;
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
    protected $description = 'Backup database and images';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $zip = new ZipArchive();

        $zip->open(config('backup.filename'), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $images = File::files(config('backup.files'));

        foreach ($images as $image) {
            $zip->addFile($image->getPathname(), 'images/'.$image->getFilename());
        }

        Dumper::dump(config('backup.database'));

        $zip->addFile(config('backup.database'), 'database.sql');

        $zip->close();

        unlink(config('backup.database'));

        $this->info('Backup created successfully!');

        return 0;
    }
}
