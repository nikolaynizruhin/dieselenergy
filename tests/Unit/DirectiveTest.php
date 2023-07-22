<?php

it('compiles uah directive', function () {
    expect('@uah(100000)')->toBeCompiled('1 000 ₴');
});

it('compiles markdown directive', function () {
    expect('@markdown("# Markdown")')->toBeCompiled("<h1>Markdown</h1>\n");
});
