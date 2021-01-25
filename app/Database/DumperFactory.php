<?php

namespace App\Database;

use InvalidArgumentException;

class DumperFactory
{
    public static function make($config)
    {
        switch ($config['driver']) {
            case 'mysql':
                return new MySQLDumper($config);
            case 'sqlite':
                return new SQLiteDumper($config);
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}].");
    }
}
