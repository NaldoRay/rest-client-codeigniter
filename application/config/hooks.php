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

$hook['pre_controller'] = array(
    'class' => 'ACL',
    'function' => 'check_acl',
    'filename' => 'ACL.php',
    'filepath' => 'core/acl',
);

$hook['post_controller_constructor'] = array(
    'class' => 'ACL',
    'function' => 'checkFunction',
    'filename' => 'ACL.php',
    'filepath' => 'core/acl',
);

