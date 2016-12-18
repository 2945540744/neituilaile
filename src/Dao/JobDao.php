<?php

namespace Neitui\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface JobDao extends GeneralDaoInterface
{
    public function searchJobs();

    public function findByUserId($userId);
}
