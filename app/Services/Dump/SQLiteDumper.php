<?php

namespace App\Services\Dump;

class SQLiteDumper extends Dumper
{
    /**
     * Dump database.
     */
    public function dump(string $path)
    {
        $command = 'sqlite3 "${:SOURCE}" .dump > "${:DESTINATION}"';

        $parameters = [
            'SOURCE' => $this->config['database'],
            'DESTINATION' => $path,
        ];

        $this->run($command, $parameters);
    }
}
