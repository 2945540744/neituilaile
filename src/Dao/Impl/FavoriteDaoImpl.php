<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\FavoriteDao;

class FavoriteDaoImpl implements FavoriteDao
{
    protected $table = 'n2_favorite';

    public function getFavorite($jobId, $userId)
    {
        return $this->getByFields(array('fav_type_id' => $jobId, 'member_id' => $userId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created')
        );
    }
}
