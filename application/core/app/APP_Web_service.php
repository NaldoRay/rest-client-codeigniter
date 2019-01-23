<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author Ray Naldo
 */
class APP_Web_service extends MY_Web_service
{
    private $autoRefreshToken = true;
    private $fileViewer;


    public function __construct ($baseUrl)
    {
        parent::__construct($baseUrl);

        $this->fileViewer = new FileViewer();
        $this->resetEachRequest(false);
    }

    public function get ($uri = '', GetParam $param = null)
    {
        $this->setRequestHeaders();

        $response = parent::get($uri, $param);
        if ($this->shouldRefreshToken($response))
        {
            // token expired, request (new) token
            $authResponse = $this->refreshToken();
            if ($authResponse->success)
            {
                // resend request with new token
                $this->setRequestHeaders();
                $response = parent::get($uri, $param);
            }
        }
        $this->reset();

        return $response;
    }

    public function post ($uri = '', array $params = null)
    {
        $this->setRequestHeaders();

        $response = parent::post($uri, $params);
        if ($this->shouldRefreshToken($response))
        {
            // token expired, request (new) token
            $authResponse = $this->refreshToken();
            if ($authResponse->success)
            {
                // resend request with new token
                $this->setRequestHeaders();
                $response = parent::post($uri, $params);
            }
        }
        $this->reset();

        return $response;
    }

    public function put ($uri = '', array $params = null)
    {
        $this->setRequestHeaders();

        $response = parent::put($uri, $params);
        if ($this->shouldRefreshToken($response))
        {
            // token expired, request (new) token
            $authResponse = $this->refreshToken();
            if ($authResponse->success)
            {
                // resend request with new token
                $this->setRequestHeaders();
                $response = parent::put($uri, $params);
            }
        }
        $this->reset();

        return $response;
    }

    public function patch ($uri = '', array $params = null)
    {
        $this->setRequestHeaders();

        $response = parent::patch($uri, $params);
        if ($this->shouldRefreshToken($response))
        {
            // token expired, request (new) token
            $authResponse = $this->refreshToken();
            if ($authResponse->success)
            {
                // resend request with new token
                $this->setRequestHeaders();
                $response = parent::patch($uri, $params);
            }
        }
        $this->reset();

        return $response;
    }

    public function delete ($uri = '', array $params = null)
    {
        $this->setRequestHeaders();

        $response = parent::delete($uri, $params);
        if ($this->shouldRefreshToken($response))
        {
            // token expired, request (new) token
            $authResponse = $this->refreshToken();
            if ($authResponse->success)
            {
                // resend request with new token
                $this->setRequestHeaders();
                $response = parent::delete($uri, $params);
            }
        }
        $this->reset();

        return $response;
    }

    public function viewFile ($uri = '', $renamedFilename = null, array $headers = null, $caFilePath = null)
    {
        $authorization = $this->getAuthorizationHeaderValue();
        if (!is_null($authorization))
            $headers['Authorization'] = $authorization;

        $this->fileViewer->viewRemoteFile($this->getEndpointUrl($uri), $renamedFilename, $headers, $caFilePath);
    }

    public function downloadFile ($uri = '', $renamedFilename = null, array $headers = null, $caFilePath = null)
    {
        $authorization = $this->getAuthorizationHeaderValue();
        if (!is_null($authorization))
            $headers['Authorization'] = $authorization;

        $this->fileViewer->downloadRemoteFile($this->getEndpointUrl($uri), $renamedFilename, $headers, $caFilePath);
    }

    public function readFile ($uri = '', array $headers = null, $caFilePath = null)
    {
        $authorization = $this->getAuthorizationHeaderValue();
        if (!is_null($authorization))
            $headers['Authorization'] = $authorization;

        return $this->fileViewer->readRemoteFile($this->getEndpointUrl($uri), $headers, $caFilePath);
    }

    private function setRequestHeaders ()
    {
        $authorization = $this->getAuthorizationHeaderValue();
        if (!is_null($authorization))
            $this->setHeader('Authorization', $authorization);

        $CI =& get_instance();
        $this->setHeader('X-Client-IP', $CI->input->ip_address());
    }

    private function getAuthorizationHeaderValue ()
    {
        $accessToken = self::getAccessToken();
        if (is_null($accessToken))
        {
            return null;
        }
        else
        {
            $token = base64_encode(sprintf('%s:%s:%s', getControllerName(), getFunctionName(), $accessToken));
            return 'Bearer '. $token;
        }
    }

    /**
     * @param bool $autoRefresh
     */
    protected function autoRefreshToken ($autoRefresh)
    {
        $this->autoRefreshToken = $autoRefresh;
    }

    private function shouldRefreshToken ($response)
    {
        return (!$response->success && $response->statusCode == 401 && $this->autoRefreshToken);
    }

    private function refreshToken ()
    {
        $CI = get_instance();
        $CI->load->service(ACL_Service::class);
        $authResponse = $CI->acl_service->authorizeUser(getAppId(), getUserId());
        if ($authResponse->success)
        {
            $auth = $authResponse->data;
            self::setAccessToken($auth->token);
        }
        else
        {
            $authResponse = (object)[
                'success' => false,
                'statusCode' => 401,
                'error' => [
                    'domain' => 'Token Authorization',
                    'message' => 'Token expired'
                ]
            ];
        }

        return $authResponse;
    }

    private static function getAccessToken ()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

    public static function setAccessToken ($token)
    {
        $_SESSION['token'] = $token;
    }
}