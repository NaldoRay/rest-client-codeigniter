<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/webclient/WebService.php';

/**
 * @author Ray Naldo
 */
class MY_Web_service extends WebService
{
    public function get ($uri = '', array $filters = null, array $searches = null, array $fields = null, array $sorts = null, $limit = -1, $offset = 0)
    {
        $params = array();
        if (!empty($filters))
        {
            foreach ($filters as $field => $value)
            {
                $key = sprintf('filters[%s]', $field);
                $params[$key] = $value;
            }
        }
        if (!empty($searches))
        {
            foreach ($searches as $field => $value)
            {
                $key = sprintf('searches[%s]', $field);
                $params[$key] = $value;
            }
        }
        if (!empty($fields))
            $params['fields'] = implode(',', $fields);
        if (!empty($sorts))
            $params['sorts'] = implode(',', $sorts);
        if ($limit > 0)
            $params['limit'] = $limit;
        if ($offset > 0)
            $params['offset'] = $offset;

        return parent::get($uri, $params);
    }

    public function search ($uri, SearchCondition $condition, array $fields = null, array $sorts = null, $limit = -1, $offset = 0)
    {
        $params = json_decode(json_encode($condition), true);

        $queryParams = array();
        if (!empty($fields))
            $queryParams['fields'] = implode(',', $fields);
        if (!empty($sorts))
            $queryParams['sorts'] = implode(',', $sorts);
        if ($limit > 0)
            $queryParams['limit'] = $limit;
        if ($offset > 0)
            $queryParams['offset'] = $offset;

        if (!empty($queryParams))
        {
            $hasQueryParam = parse_url($uri, PHP_URL_QUERY);
            $uri .= ($hasQueryParam ? '&' : '?') . http_build_query($queryParams);
        }

        return parent::post($uri, $params);
    }
}