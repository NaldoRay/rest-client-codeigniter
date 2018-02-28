<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('ComparisonCondition.php');

/**
 * @author Ray Naldo
 */
class LessThanCondition extends ComparisonCondition
{
    public function __construct ($field, $value)
    {
        parent::__construct($field, '<', $value);
    }
}