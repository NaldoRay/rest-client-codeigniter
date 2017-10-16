<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: Ray N
 * Date: 5/3/2017
 * Time: 09:30
 * 
 */
class MY_Controller extends CI_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->helper(['file', 'log']);
    }
}