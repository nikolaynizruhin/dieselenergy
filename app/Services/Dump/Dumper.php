<?php

namespace App\Services\Dump;

use Symfony\Component\Process\Process;

abstract class Dumper
{
    /**
     * Dumper constructor.
     *
     * @param  array  $config
     */
    public function __construct(readonly protected array $config)
    {
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
    protected function run(string $command, array $parameters): void
    {
        $process = Process::fromShellCommandline($command);

        $process->mustRun(null, $parameters);
    }
}
