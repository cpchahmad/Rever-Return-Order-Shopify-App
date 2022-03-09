<?php

if (! function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * This is a polyfill for the missing shorthand function in lumen.
     *
     * @param  string  $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath('config').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('proxy')) {
    function proxy($route) {
        if(env('APP_ENV')!='local')
        {
            return str_replace(env('APP_URL'),env('PROXY_URL'),$route);
        }else
        {
            return $route;
        }
    }
}



