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
