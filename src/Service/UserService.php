<?php

namespace Neitui\Service;

interface UserService
{
    public function getUserByUsername($username);

    public function getUserByWxUnionId($wid);
}
