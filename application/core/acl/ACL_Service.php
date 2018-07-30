<?php
/**
 * Project name: SIA DEV
 * Author: Avin
 * Date & Time: 7/6/2018 - 8:48 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class ACL_Service extends MY_Web_service
{
    public function __construct()
    {
        //parent::__construct('http://10.210.1.177/ws_acl_new/');
        parent::__construct('http://10.211.1.34/ws_acl_new/');
        //parent::__construct('http://10.210.111.40/v2/');
    }

    public function getUserMenu($data)
    {
        $response = $this->post("getUserMenu2", $data);
        return $response;
    }

    public function cekLink($data)
    {
        $response = $this->post("cek_link", $data);
        return $response;
    }

    public function authorizeUser($id_appl, $username)
    {
        return $this->post("auth",
            [
                'id_appl' => $id_appl,
                'username' => $username
            ]
        );
    }

    public function logout()
    {
        return $this->setHeader('Authorization', 'Bearer ' . $this->getAccessToken())
            ->post("logout");
    }

    private function getAccessToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

}