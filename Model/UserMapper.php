<?php

namespace Model;

class UserMapper
{
    public function createUserFromArray(array $dataArray): User
    {
        $user = new User();
        $user->setUserId($dataArray['id']);
        $user->setUserName($dataArray['username']);

        return $user;
    }
}