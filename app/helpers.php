<?php

if (! function_exists('view_modified_date')) {

    /**
     * Get view modified date.
     *
     * @param  string  $path
     * @param  string  $format
     * @return string
     */
    function view_modified_date($path, $format = 'Y-m-d')
    {
        return date($format, filemtime(resource_path('views/'.$path.'.blade.php')));
    }
}

if (! function_exists('pages')) {

    /**
     * Get amount of pages.
     *
     * @param  int  $total
     * @param  int  $perPage
     * @return int
     */
    function pages($total, $perPage = 9)
    {
        return max((int) ceil($total / $perPage), 1);
    }
}
