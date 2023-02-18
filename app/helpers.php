<?php

if (! function_exists('view_modified_date')) {
    /**
     * Get view modified date.
     */
    function view_modified_date(string $path, string $format = 'Y-m-d'): string
    {
        return date($format, filemtime(resource_path('views/'.$path.'.blade.php')));
    }
}

if (! function_exists('pages')) {
    /**
     * Get amount of pages.
     */
    function pages(int $total, int $perPage = 9): int
    {
        return max((int) ceil($total / $perPage), 1);
    }
}
