<?php

it('compiles uah_directive', function () {
    assertDirectiveOutput('1 000 ₴', '@uah(100000)');
});

it('compiles markdown_directive', function () {
    assertDirectiveOutput("<h1>Markdown</h1>\n", '@markdown("# Markdown")');
});

function assertDirectiveOutput(string $expected, string $directive): void
{
    ob_start();

    eval('?>'.app('blade.compiler')->compileString($directive));

    test()->assertEquals($expected, ob_get_clean());
}
