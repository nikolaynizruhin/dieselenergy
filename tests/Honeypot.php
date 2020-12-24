<?php

namespace Tests;

trait Honeypot
{
    /**
     * Valid honeypot field.
     *
     * @return array
     */
    protected function honeypot()
    {
        return [
            config('honeypot.valid_from_field') => time() - (config('honeypot.seconds') + 1),
        ];
    }
}
