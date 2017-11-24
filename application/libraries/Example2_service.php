<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Rest_service.php';

/**
 * @author Ray Naldo
 */
class Example2_service extends Rest_service
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