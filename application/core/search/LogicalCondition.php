<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('SearchCondition.php');

/**
 * @author Ray Naldo
 */
class LogicalCondition implements SearchCondition
{
    private $logicalOperator;
    /** @var SearchCondition[] */
    private $conditions;


    public static function logicalAnd (array $conditions)
    {
        return new LogicalCondition('AND', $conditions);
    }

    public static function logicalOr (array $conditions)
    {
        return new LogicalCondition('OR', $conditions);
    }

    /**
     * MY_Condition constructor.
     * @param string $operator
     * @param SearchCondition[] $conditions
     */
    private function __construct ($operator, array $conditions)
    {
        $this->logicalOperator = $operator;
        $this->conditions = $conditions;
    }

    public function jsonSerialize ()
    {
        return get_object_vars($this);
    }
}