<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Overrides CI Loader so we could run custom initialization code.
 * https://codeigniter.com/user_guide/general/core_classes.html#extending-core-class
 *
 * @author Ray Naldo
 */
class MY_Loader extends CI_Loader
{
    private $includeDirectories;
    private $excludeDirectories;


    public function initialize ()
    {
        parent::initialize();

        // register autoloader
        $this->includeDirectories  = array(
            APPPATH.'core',
            APPPATH.'services'
        );
        $this->excludeDirectories = array();

        spl_autoload_register(function ($class) {
            self::autoloadClass($this->includeDirectories, $class);
        });

        // load helper
        include_once(APPPATH.'core/helpers/core_helper.php');
        include_once(APPPATH.'core/acl/acl_helper.php');
    }

    /**
     * Autoload application class recursively.
     * @param array $directories
     * @param string $class
     */
    private function autoloadClass (array $directories, $class)
    {
        foreach ($directories as $directory)
        {
            if (!in_array($directory, $this->excludeDirectories))
            {
                $filePath = $directory . DIRECTORY_SEPARATOR . $class . '.php';
                if (file_exists($filePath))
                {
                    require_once ($filePath);
                    return;
                }
                else
                {
                    $subDirectories = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
                    self::autoloadClass($subDirectories, $class);
                }
            }
        }
    }

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
