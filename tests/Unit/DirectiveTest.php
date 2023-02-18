<?php

namespace Tests\Unit;

use Tests\TestCase;

class DirectiveTest extends TestCase
{
    /** @test */
    public function it_compiles_uah_directive(): void
    {
        $this->assertDirectiveOutput('1 000 ₴', '@uah(100000)');
    }

    /** @test */
    public function it_compiles_markdown_directive(): void
    {
        $this->assertDirectiveOutput("<h1>Markdown</h1>\n", '@markdown("# Markdown")');
    }

    /**
     * Assert directive output.
     */
    private function assertDirectiveOutput(string $expected, string $directive): void
    {
        ob_start();

        eval('?>'.app('blade.compiler')->compileString($directive));

        $this->assertEquals($expected, ob_get_clean());
    }
}
