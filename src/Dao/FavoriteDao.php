<?php

namespace Neitui\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FavoriteDao extends GeneralDaoInterface
{
    public function getFavorite($jobId, $userId);

    public function getFavorites($userId);
}
