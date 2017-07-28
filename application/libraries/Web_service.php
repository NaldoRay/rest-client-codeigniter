<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'webclient/WebClient.php';


class Web_service
{
	private $webClient;
	
	public function __construct ()
	{
		$this->webClient = new WebClient('http://localhost/');
	}
	
	
	public function getStubs ()
	{
		return $this-get('stubs');
	}
	
	public function getResources ()
	{
		try
		{
			$response = $this->webClient->get('resources');
			return $this->getResponseData($response);
		}
		catch (WebException $e)
		{
			return $this->getErrorData($e);
		}
	}
	
	/**
     * @param $uri
     * @param array $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     * @throws WebException
     */
    public function get ($uri, array $params = null)
    {
        try
        {
            $response = $this->webClient->get($uri, $params);
            return $this->getResponseData($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorData($e);
        }
    }

    /**
     * @param $uri
     * @param array|null $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     * @throws WebException
     */
    public function post ($uri, array $params = null)
    {
        try
        {
            $response = $this->webClient->post($uri, $params);
            return $this->getResponseData($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorData($e);
        }
    }

    /**
     * @param $uri
     * @param array|null $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     * @throws WebException
     */
    public function patch ($uri, array $params = null)
    {
        try
        {
            $response = $this->webClient->patch($uri, $params);
            return $this->getResponseData($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorData($e);
        }
    }

    /**
     * @param $uri
     * @param array|null $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     * @throws WebException
     */
    public function delete ($uri, array $params = null)
    {
        try
        {
            $response = $this->webClient->delete($uri, $params);
            return $this->getResponseData($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorData($e);
        }
    }
	
	
	private function getResponseData (WebResponse $response)
	{
		$body = $response->getBody();
		$body->success = true;
		return $body;
	}
	
	private function getErrorData (WebException $e)
	{
		$body = $e->getResponse()->getBody();
		$body->success = false;
		return $body;
	}
}

?>