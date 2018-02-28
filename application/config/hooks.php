<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_system'] = function ()
{
    spl_autoload_register(function ($class)
    {
        if (strpos($class, 'APP_') === 0)
        {
            $filePath = sprintf('%score/app/%s.php', APPPATH, $class);
        }
        else if (strpos($class, 'Condition') !== false)
        {
            $filePath = sprintf('%score/search/%s.php', APPPATH, $class);
        }
        else
        {
            $filePath = $class . '.php';
        }

        if (file_exists($filePath))
            include_once($filePath);
    });
};
