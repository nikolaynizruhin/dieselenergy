<?php

namespace App\Services\Dump;

use InvalidArgumentException;

class DumperFactory
{
    /**
     * Dumper factory.
     *
     * @param  array  $config
     * @return \App\Services\Dump\Dumper
     */
    public static function make(array $config)
    {
        return match ($config['driver']) {
            'mysql' => new MySQLDumper($config),
            'sqlite' => new SQLiteDumper($config),
            default => throw new InvalidArgumentException("Unsupported driver [{$config['driver']}]."),
        };
    }
}
