<?php

namespace Model;

class User
{

    protected string $userName = '';
    protected int $userId = 0;

    public function getUserName(): string
    {
        return $this->userName;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}