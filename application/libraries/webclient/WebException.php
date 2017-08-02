<?php

require_once 'WebResponse.php';

/**
 * User: RN
 * Date: 5/24/2017
 * Time: 09:25
 */
class WebException extends Exception
{
    private $response;

    public function __construct (WebResponse $response)
    {
        parent::__construct();
        $this->response = $response;
    }

    public function getResponse ()
    {
        return $this->response;
    }
}