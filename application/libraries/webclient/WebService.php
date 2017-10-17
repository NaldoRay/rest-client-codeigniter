<?php

require_once 'WebClient.php';

/**
 * User: Ray N
 * Date: 8/2/2017
 * Time: 08:19
 */
class WebService
{
	private $webClient;
	private $baseUrl;
	
	public function __construct ($baseUrl)
	{
		$this->webClient = new WebClient($baseUrl);
		$this->baseUrl = $baseUrl;
	}
	
	protected function getEndpointUrl ($uri)
    {
        return sprintf('%s%s', $this->baseUrl, $uri);
    }

	public function attachFile ($name, $filePath)
    {
        $this->webClient->attachFile($name, $filePath);
        return $this;
    }

	/**
     * @param $uri
     * @param array $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     */
    public function get ($uri = '', array $params = null)
    {
        try
        {
            $response = $this->webClient->get($uri, $params);
            return $this->getResponseBody($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorBody($e);
        }
    }

    /**
     * @param $uri
     * @param array|null $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     */
    public function post ($uri = '', array $params = null)
    {
        try
        {
            $response = $this->webClient->post($uri, $params);
            return $this->getResponseBody($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorBody($e);
        }
    }

    /**
     * @param $uri
     * @param array|null $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     */
    public function patch ($uri = '', array $params = null)
    {
        try
        {
            $response = $this->webClient->patch($uri, $params);
            return $this->getResponseBody($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorBody($e);
        }
    }

    /**
     * @param $uri
     * @param array|null $params
     * @return object jika sukses {success: true, data: object|array} , jika gagal {success: false, error: object}
     * @throws LogicException
     */
    public function delete ($uri = '', array $params = null)
    {
        try
        {
            $response = $this->webClient->delete($uri, $params);
            return $this->getResponseBody($response);
        }
        catch (WebException $e)
        {
            return $this->getErrorBody($e);
        }
    }

    private function getErrorBody (WebException $e)
    {
        $response = $e->getResponse();

        $body = $this->getResponseBody($response);
        if (!isset($body->error))
        {
            $error = new stdClass();
            $error->domain = '';
            $error->message = '';

            $body->error = $error;
        }

        return $body;
    }

	private function getResponseBody (WebResponse $response)
	{
		$body = $response->getBody();
		if (is_null($body))
        {
            $body = new stdClass();
        }
		$body->success = $response->isSuccess();
		$body->statusCode = $response->getStatusCode();

		return $body;
	}
}

