<?php

namespace Tests\Unit;

use Tests\TestCase;

class DirectiveTest extends TestCase
{
    /** @test */
    public function it_compiles_usd_directive()
    {
        $this->assertDirectiveOutput('$1 000.00', '@usd(100000)');
    }

    /** @test */
    public function it_compiles_uah_directive()
    {
        $this->assertDirectiveOutput('₴25 000.00', '@uah(100000)');
    }

    /**
     * Assert directive output.
     *
     * @param  string  $expected
     * @param  string  $directive
     */
    private function assertDirectiveOutput($expected, $directive)
    {
        ob_start();

        eval('?>'.app('blade.compiler')->compileString($directive));

        $this->assertEquals($expected, ob_get_clean());
    }
}
