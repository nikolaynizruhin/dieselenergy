<?php

namespace App\Dump;

class MySQLDumper extends Dumper
{
    /**
     * Dump database.
     *
     * @param  string  $path
     */
    public function dump($path)
    {
        $command = 'mysqldump -u"${:USERNAME}" -p"${:PASSWORD}" "${:DATABASE}" > "${:DESTINATION}"';

        $parameters = [
            'USERNAME' => $this->config['username'],
            'PASSWORD' => $this->config['password'],
            'DATABASE' => $this->config['database'],
            'DESTINATION' => $path,
        ];

        $this->run($command, $parameters);
    }
}
