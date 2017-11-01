#####################################

 Menambahkan client ke project yang sudah ada
 
######################################

1. Copy folder `vendor` dan `application/libraries/webclient` ke path yang sama pada folder project yang sudah ada.

2. Edit application/config.php
```
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';
```

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
