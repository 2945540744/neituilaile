<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\FavoriteDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FavoriteDaoImpl extends GeneralDaoImpl implements FavoriteDao
{
    protected $table = 'n2_favorite';

    public function getFavorite($jobId, $userId)
    {
        return $this->getByFields(array('fav_type' => 1, 'fav_type_id' => $jobId, 'member_id' => $userId));
    }

    public function getFavorites($userId)
    {
        $sql = "SELECT j.*, c.short_name, d.id AS 'deliveryed' FROM n2_job j LEFT JOIN n2_company c ON j.company_id = c.id LEFT JOIN (select max(id) as 'id', delivery_job_id from n2_resume_delivery group by delivery_job_id) d ON j.id = d.delivery_job_id WHERE j.status <> '关闭' AND j.id IN (SELECT fav_type_id AS 'job_id' FROM n2_favorite f WHERE member_id=? AND fav_type=1 ) ORDER BY updated DESC limit 1000";
        return $this->db()->fetchAll($sql, array($userId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created')
        );
    }
}
