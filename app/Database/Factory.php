<?php

namespace App\Database;

use InvalidArgumentException;

class Factory
{
    public static function make($config)
    {
        switch ($config['driver']) {
            case 'mysql':
                return new MySQL($config);
            case 'sqlite':
                return new SQLite($config);
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}].");
    }
}
