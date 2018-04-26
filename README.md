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
v.2.0.0
+ `MY_Web_service` now has a `WebService` (before was subclass of `WebService`)
+ Refactor get/search parameters to `GetParam` and `SearchParam`

v1.4.2
+ Fix missing `Content-Type` when uploading file with `PUT`, move `attachUploadedFile` to `WebClient`
+ Move `Web_service` library to `core/app`, support same base url for multiple service
+ Add helper to group object array
+ Add js helper to show form errors from response
+ Add advanced `search` method, supports fields filtering, sorts, limit and offset
+ Change `get` method  signature in `MY_Web_Service`
+ Replace library `File_viewer` with `File_manager`
+ Change function to get file content type to `mime_content_type()`
+ Move web service class path to `application/services` for easier maintenance
+ Add helper method to load service class from loader e.g. `$this->load->service(User_service::class)`

v1.3.1
+ Simplify  GET process

v1.3.0
+ Add attach uploaded file
+ Add 'filters' parameter on WebService's GET method
+ Add method to add multipart's form data, disable auto json_encode multipart's form data
+ Show 404 not found if file url doesn't exist

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
