<?php

/**
 * @author Ray Naldo
 */
class APP_Localhost_service extends APP_Web_service
{
    public function __construct ($uri)
    {
        parent::__construct(sprintf('http://localhost/api/%s', $uri));
    }
}