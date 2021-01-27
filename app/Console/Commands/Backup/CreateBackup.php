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
     * Local storage.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    private $storage;

    /**
     * Zip archive.
     *
     * @var \ZipArchive
     */
    private $zip;

    public function __construct()
    {
        parent::__construct();

        $this->zip = new ZipArchive();
        $this->storage = Storage::disk('local');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->zip->open(
            $this->storage->path(config('backup.filename')),
            ZipArchive::CREATE | ZipArchive::OVERWRITE,
        );

        $images = $this->storage->files(config('backup.files'));

        foreach ($images as $image) {
            $this->zip->addFile($this->storage->path($image), $image);
        }

        Dumper::dump($this->storage->path(config('backup.database')));

        $this->zip->addFile($this->storage->path(config('backup.database')), 'database.sql');

        $this->zip->close();

        $this->storage->delete(config('backup.database'));

        $this->info('Backup created successfully!');

        return 0;
    }
}
