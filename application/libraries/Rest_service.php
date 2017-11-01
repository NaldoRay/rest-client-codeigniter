<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Author: Ray N
 * Date: 10/24/2017
 * Time: 14:49
 */
class Rest_service extends WebService
{
    private $inupby = null;

    public function setInupby ($inupby)
    {
        $this->inupby = $inupby;
        return $this;
    }

    public function post ($uri = '', array $params = null)
    {
        if (!is_null($this->inupby))
            $this->setHeader('API-User', $this->inupby);

        return parent::post($uri, $params);
    }

    public function put ($uri = '', array $params = null)
    {
        if (!is_null($this->inupby))
            $this->setHeader('API-User', $this->inupby);

        return parent::put($uri, $params); // TODO: Change the autogenerated stub
    }

    public function patch ($uri = '', array $params = null)
    {
        if (!is_null($this->inupby))
            $this->setHeader('API-User', $this->inupby);

        return parent::patch($uri, $params); // TODO: Change the autogenerated stub
    }
}