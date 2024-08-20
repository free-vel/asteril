<?php
namespace Repositories\AsterilRepository;

/**
 * tree page model
 */
class AsterilRepository extends \Repositories\BaseApiRepository\BaseApiRepository
{
    /**
     * @param string $type
     * @return array
     */
    public function getParams(string $type = 'Asteril/Orders'): array
    {
        return $this->db->query("SELECT `id`, `params` FROM `api_params` WHERE `type` = '".$type."'");
    }

    /**
     *
     * @param int $paramsId
     * @return array
     */
    public function getChangeCriteria(int $paramsId): array
    {
        return $this->db->query("SELECT * FROM `api_change_criteria` WHERE `api_params_id` = '".$paramsId."'");
    }
}