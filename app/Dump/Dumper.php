<?php

namespace App\Dump;

use Symfony\Component\Process\Process;

abstract class Dumper
{
    /**
     * Database connection config.
     *
     * @var array
     */
    protected array $config;

    /**
     * Dumper constructor.
     *
     * @param  array  $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Dump database.
     *
     * @param  string  $path
     */
    abstract public function dump(string $path);

    /**
     * Run shell command.
     *
     * @param  string  $command
     * @param  array  $parameters
     */
    protected function run(string $command, array $parameters)
    {
        $process = Process::fromShellCommandline($command);

        $process->mustRun(null, $parameters);
    }
}
