<?php

namespace App\Services\Dump;

use Symfony\Component\Process\Process;

abstract class Dumper
{
    /**
     * Dumper constructor.
     */
    public function __construct(readonly protected array $config) {}

    /**
     * Dump database.
     */
    abstract public function dump(string $path);

    /**
     * Run shell command.
     */
    protected function run(string $command, array $parameters): void
    {
        $process = Process::fromShellCommandline($command);

        $process->mustRun(null, $parameters);
    }
}
