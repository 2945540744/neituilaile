<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\FavoriteDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FavoriteDaoImpl extends GeneralDaoImpl implements FavoriteDao
{
    protected $table = 'n2_favorite';

    public function getFavorite($jobId, $userId)
    {
        return $this->getByFields(array('fav_type_id' => $jobId, 'member_id' => $userId));
    }

    public function getFavorites($userId)
    {
        return $this->findInField('member_id', array($userId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created')
        );
    }
}
