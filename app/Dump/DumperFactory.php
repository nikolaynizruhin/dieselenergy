<?php

namespace App\Dump;

use InvalidArgumentException;

class DumperFactory
{
    /**
     * Dumper factory.
     *
     * @param  array  $config
     * @return \App\Dump\Dumper
     */
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
