<?php

/**
 * Date: 10/18/2017
 * Time: 11:49
 */

if (!function_exists('getUsername'))
{
    function getUsername ()
    {
        // TODO ganti dengan implementasi yang benar
        return 'username';
    }
}

if (!function_exists('groupObjectArray'))
{
    function groupObjectArray (array $arr, array $groupFields)
    {
        $groupedArr = array();

        $countGroup = count($groupFields);
        foreach ($arr as $row)
        {
            $group =& $groupedArr;
            for ($i = 0; $i < $countGroup; $i++)
            {
                $fieldName = $groupFields[$i];
                $fieldValue = $row->$fieldName;

                if (!isset($group[$fieldValue]))
                    $group[$fieldValue] = array();

                if ($i == ($countGroup-1))
                    $group[$fieldValue][] = $row;
                else
                    $group =& $group[$fieldValue];
            }
        }

        return $groupedArr;
    }
}

