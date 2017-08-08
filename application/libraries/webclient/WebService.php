<?php

require_once 'WebClient.php';


class WebService
{
	private $webClient;
	
	public function __construct ($baseUrl)
	{
		$this->webClient = new WebClient($baseUrl);
	}

	/**
     * @param $uri
     * @param array $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     * @throws WebException
     */
    public function get ($uri = '', array $params = null)
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
    public function post ($uri = '', array $params = null)
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
    public function patch ($uri = '', array $params = null)
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
    public function delete ($uri = '', array $params = null)
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
		if (is_null($body))
        {
            $body = new stdClass();
        }
		$body->success = true;
		$body->statusCode = $response->getStatusCode();

		return $body;
	}
	
	private function getErrorData (WebException $e)
	{
        $response = $e->getResponse();

		$body = $response->getBody();
        if (is_null($body))
        {
            $body = new stdClass();
        }
		$body->success = false;
        $body->statusCode = $response->getStatusCode();

		return $body;
	}
}

