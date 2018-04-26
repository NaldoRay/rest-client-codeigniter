<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Ray Naldo
 */
class SearchParam extends RequestParam
{
    /** @var SearchCondition */
    private $condition;


    public static function createSearch (SearchCondition $condition)
    {
        return self::create()->search($condition);
    }

    protected function __construct ()
    {
        parent::__construct();
        $this->resetSearch();
    }

    /**
     * @return SearchCondition
     */
    public function getSearchCondition ()
    {
        return $this->condition;
    }

    /**
     * @param SearchCondition $condition
     * @return $this
     */
    public function search (SearchCondition $condition)
    {
        $this->condition = $condition;
        return $this;
    }

    public function resetSearch ()
    {
        $this->condition = null;
        return $this;
    }
}