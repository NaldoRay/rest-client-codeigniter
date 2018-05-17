<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Overrides CI Database Loader so we could load our (custom) db driver extension.
 * https://github.com/bcit-ci/CodeIgniter/wiki/Extending-Database-Drivers
 * http://forum.codeigniter.com/thread-35992.html
 *
 * @author Modified by Ray Naldo
 */
class MY_Loader extends CI_Loader
{
    public function service ($service, $object_name = null)
    {
        $CI =& get_instance();

        if (empty($object_name))
            $object_name = strtolower($service);

        if (!isset($CI->$object_name))
            $CI->$object_name = new $service();

        return $this;
    }
}
