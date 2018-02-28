<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('SearchCondition.php');

/**
 * @author Ray Naldo
 */
abstract class ComparisonCondition implements SearchCondition
{
    private $field;
    private $operator;
    private $value;


    /**
     * QuerySimpleCondition constructor.
     * @param string $field
     * @param string $operator
     * @param mixed $value
     */
    protected function __construct ($field, $operator, $value)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function jsonSerialize ()
    {
        return get_object_vars($this);
    }
}