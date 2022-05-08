<?php

namespace App\Dump;

class SQLiteDumper extends Dumper
{
    /**
     * Dump database.
     *
     * @param string $path
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
