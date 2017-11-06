<?php

require_once 'WebClient.php';

/**
 * @author Ray Naldo
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

    public function setHeader ($field, $value)
    {
        $this->webClient->setHeader($field, $value);
        return $this;
    }

    public function attachUploadedFile ($name, $fileField)
    {
        $filePath = $_FILES[$fileField]['tmp_name'];
        return $this->attachFile($name, $filePath);
    }

    public function attachFile ($name, $filePath)
    {
        $this->webClient->attachFile($name, $filePath);
        return $this;
    }

    /**
     * @param string $uri
     * @param array $params
     * @param array $filters
     * @return object on success {success: true, data: object|array}, on failed {success: false, error: object}
     * on failed {success: false, error: object}
     */
    public function get ($uri = '', array $params = null, array $filters = null)
    {
        if (!is_null($filters))
        {
            if (is_null($params))
                $params = array();

            foreach ($filters as $key => $value)
            {
                $field = sprintf('filters[%s]', $key);
                $params[$field] = $value;
            }
        }

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
     * @return object on success {success: true, data: object|array}, on failed {success: false, error: object}
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
     * @return object on success {success: true, data: object|array}, on failed {success: false, error: object}
     */
    public function put ($uri = '', array $params = null)
    {
        try
        {
            $response = $this->webClient->put($uri, $params);
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
     * @return object on success {success: true, data: object|array}, on failed {success: false, error: object}
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
     * @return object on success {success: true, data: object|array}, on failed {success: false, error: object}
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

