#####################################

 Menambahkan client ke project yang sudah ada
 
######################################

1. Copy folder `vendor` dan `application/libraries/webclient` ke path yang sama pada folder project yang sudah ada.

2. Edit application/config.php
```
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';
```

