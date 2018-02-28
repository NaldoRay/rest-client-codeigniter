<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('ComparisonCondition.php');

/**
 * @author Ray Naldo
 */
class ContainsCondition extends ComparisonCondition
{
    public function __construct ($field, $values)
    {
        parent::__construct($field, '~', $values);
    }
}