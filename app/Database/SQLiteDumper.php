<?php

namespace App\Database;

class SQLiteDumper extends Dumper
{
    public function dump($path)
    {
        $command = 'sqlite3 "${:SOURCE}" .dump > "${:DESTINATION}"';

        $parameters = [
            'SOURCE' => $this->config['database'],
            'DESTINATION' => $path,
        ];

        $this->run($command, $parameters);
    }
}
