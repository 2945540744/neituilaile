<?php

namespace Neitui\Dao\Impl;

// use Neitui\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class JobDaoImpl extends GeneralDaoImpl//implements UserDao

{
    protected $table = 'job';

    public function getInfoById($id = 0)
    {
        return $this->getByFields(array('id' => $id));
    }

    public function addJobInfo(array $data = [])
    {
        return $this->create($data);
    }

    public function editJobInfoById($id = 0, array $data = [])
    {
        return $this->update($id, $data);
    }

    public function declares()
    {
        return array(
//             'timestamps' => array('created', 'updated')
            'orderbys' => array('id')
        );
    }
}
