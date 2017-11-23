## Import to existing project
 

1. Copy `vendor` and `application/libraries/webclient` to the same directory structure on existing project.

2. Edit application/config.php
```
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';
```

## Changelog

v1.3.0
+ add method to attach uploaded file
+ add `filters` parameter on GET method
+ rethrow LogicException on request as WebException
+ add method to add multipart's form data, 
+ disable auto-json_encode on multipart's data, now treated as raw value
+ show 404 not found if file url doesn't exist
+ untrack/ignore release directory

v1.2.8
+ add extra data on multipart as json data (Content-Type: application/json)
+ add setter for header(s)
+ add parent service that provides setter for inupby/API-User
+ add method to forward response from server and create error response
+ add PUT method

v1.2.6
+ fix download/view remote file not working (cannot read directly from remote filepath)

v1.2.5
+ add method `attachFile` in WebService, accepts file path not file content anymore
+ add file viewer
