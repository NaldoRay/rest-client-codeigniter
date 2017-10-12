<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: RN
 * Date: 5/3/2017
 * Time: 09:30
 * 
 * @property Cas cas
 */
class MY_Controller extends CI_Controller
{
    public function __construct ()
    {
        parent::__construct();

        $this->initCasAuth();
        $this->load->helper(['file', 'log']);
    }

    private function initCasAuth ()
    {
        $this->load->library('cas');
        if ($this->cas->isAuthenticated())
        {
            $_SESSION['username'] = $this->cas->getUsername();
        }
        else
        {
            $this->cas->forceAuthentication();
            return;
        }
    }
}