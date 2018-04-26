<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Ray Naldo
 * @property MY_Loader $load
 */
class MY_Controller extends CI_Controller
{
    protected function respondError ($message, $domain = 'Global', $statusCode = 200)
    {
        $response = [
            'statusCode' => $statusCode,
            'success' => false,
            'error' => [
                'domain' => $domain,
                'message' => $message
            ]
        ];
        $this->forwardResponse($response);
    }

    protected function forwardResponse ($response)
    {
        $statusCode = (is_array($response) ? $response['statusCode'] : $response->statusCode);

        $this->output->set_status_header($statusCode);
        $this->output->set_content_type('application/json; charset=utf-8');
        $this->output->set_output(json_encode($response));
    }
}