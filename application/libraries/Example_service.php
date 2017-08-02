<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'webclient/WebService.php';

/**
 * User: RN
 * Date: 8/2/2017
 * Time: 11:18
 */
class Example_service extends WebService
{
    /**
     * ExampleService constructor.
     */
    public function __construct ()
    {
        parent::__construct('http://localhost/api/examples/');
    }

    public function getAllExamples ()
    {
        return $this->get();
    }

    public function addExample ($title, $desc)
    {
        return $this->post('', [
            'title' => $title,
            'desc' => $desc
        ]);
    }

    public function deleteExample ($id)
    {
        return $this->delete($id);
    }
}