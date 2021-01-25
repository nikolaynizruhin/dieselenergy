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
    protected $config;

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
    abstract public function dump($path);

    /**
     * Run shell command.
     *
     * @param  string  $command
     * @param  array  $parameters
     */
    protected function run($command, $parameters)
    {
        $process = Process::fromShellCommandline($command);

        $process->mustRun(null, $parameters);
    }
}
