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
	
	
	public function getDummies ()
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