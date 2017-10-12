<?php

use GuzzleHttp\Exception\RequestException;

require_once 'WebException.php';
require_once 'WebResponse.php';

/**
 * User: RN
 * Date: 5/24/2017
 * Time: 08:19
 */
class WebClient
{
	private $baseUrl = 'http://localhost/';
	
    private $auth;
    private $language;
    private $multipart;

	/**
		@param $baseUrl harus memiliki trailing slash
	*/
    public function __construct ($baseUrl)
    {
		$this->baseUrl = $baseUrl;
        $this->reset();
    }

    public function reset ()
    {
        $this->auth = null;
        $this->multipart = null;
        $this->language = 'en';
    }

    public function auth ($username, $password)
    {
        $this->auth = [$username, $password];
        return $this;
    }

    /**
     * @param string $name
     * @param string $filePath
     * @return $this
     */
    public function attachFile ($name, $filePath)
    {
        if (is_null($this->multipart))
            $this->multipart = array();

        $this->multipart[] = [
            'name' => $name,
            'contents' => fopen($filePath, 'r')
        ];

        return $this;
    }

    public function acceptLanguage ($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param string $uri
     * @param array $params
     * @return WebResponse
     * @throws LogicException
     * @throws WebException
     */
    public function get ($uri = '', array $params = null)
    {
        return $this->request('GET', $uri, $params);
    }

    /**
     * @param string $uri
     * @param array|null $params
     * @return WebResponse
     * @throws LogicException
     * @throws WebException
     */
    public function post ($uri = '', array $params = null)
    {
        return $this->request('POST', $uri, $params);
    }

    /**
     * @param string $uri
     * @param array|null $params
     * @return WebResponse
     * @throws LogicException
     * @throws WebException
     */
    public function patch ($uri = '', array $params = null)
    {
        return $this->request('PATCH', $uri, $params);
    }

    /**
     * @param string $uri
     * @param array|null $params
     * @return WebResponse
     * @throws LogicException
     * @throws WebException
     */
    public function put ($uri = '', array $params = null)
    {
        return $this->request('PUT', $uri, $params);
    }

    /**
     * @param string $uri
     * @param array|null $params
     * @return WebResponse
     * @throws LogicException
     * @throws WebException
     */
    public function delete ($uri = '', array $params = null)
    {
        return $this->request('DELETE', $uri, $params);
    }

    /**
     * @param $method
     * @param $uri
     * @param array|null $params
     * @return WebResponse
     * @throws LogicException
     * @throws WebException
     */
    private function request ($method, $uri, array $params = null)
    {
        $options = [
            'verify' => false
        ];
        if (is_null($this->multipart))
        {
            if (!is_null($params))
            {
                if ($method == 'GET')
                {
                    $options['query'] = $params;
                }
                else
                {
                    $options['json'] = $params;
                }
            }
        }
        else
        {
            if (!is_null($params))
            {
                foreach ($params as $key => $value)
                {
                    $this->multipart[] = [
                        'name' => $key,
                        'contents' => $value
                    ];
                }
            }

            $options['multipart'] = $this->multipart;
        }

        if (!is_null($this->auth))
        {
            $options['auth'] = $this->auth;
        }

        if ($method !== 'GET')
            $options['headers']['Cache-Control'] = 'no-cache';

        if (!empty($this->language))
            $options['headers']['Accept-Language'] = $this->language;

        // reset this client request settings
        $this->reset();

		$uri = $this->baseUrl . $uri;
        $client = new GuzzleHttp\Client();
        try
        {
            $response = $client->request($method, $uri, $options);
            return new WebResponse($response);
        }
        catch (RequestException $e)
        {
            $response = $e->getResponse();
            if (is_null($response))
                $response = new \GuzzleHttp\Psr7\Response(500, [], '{"error":{"type":"InternalError","message":"'.$e->getMessage().'"}}');

            throw new WebException(new WebResponse($response));
        }
    }
}