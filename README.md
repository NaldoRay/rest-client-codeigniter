## How to use
Copy this project folder, follow the examples, and use it like normal CI Project.

## Import to existing project
1. Copy `vendor`, `application/core`, and `application/libraries` to the same directory structure on existing project.
2. Edit `config/hooks.php`
```
$hook['pre_system'] = function ()
{
    spl_autoload_register(function ($class)
    {
        if (strpos($class, 'APP_') === 0)
        {
            $filePath = sprintf('%score/app/%s.php', APPPATH, $class);
            if (file_exists($filePath))
                include_once($filePath);
        }
    });
};
```
3. Edit `application/config.php`
```
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';
```

## Changelog
v1.2.8
+ add extra data on multipart as json data (Content-Type: application/json)
+ add setter for header(s)
+ add parent service that provides setter for inupby/API-User
+ Add method to forward response from server and create error response
+ Add PUT method

v1.2.6
+ Fix download/view remote file not working (cannot read directly from remote filepath)

v1.2.5
+ Add method 'attachFile' in WebService, accepts file path not file content anymore
+ Add file viewer
