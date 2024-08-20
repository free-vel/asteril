<?php

namespace Repositories\BaseApiRepository;

class BaseApiRepository
{
    protected $db;
    protected $apiId;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setApiId($apiId)
    {
        $this->apiId = $apiId;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getSettings()
    {
        $res = $this->db->query("SELECT `settings` FROM `api_settings` WHERE `api_id` = '".$this->apiId."'");
        return isset($res[0]) ? json_decode($res[0]['settings'], true) : array();
    }

}