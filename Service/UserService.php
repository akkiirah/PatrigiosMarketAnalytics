<?php

namespace Service;

use Repository\Local\UserRepository;
use Model\UserMapper;
use Model\User;

class UserService
{
    protected UserRepository $userRepository;
    protected UserMapper $userMapper;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userMapper = new UserMapper();
    }

    public function registerUser(array $data): ?User
    {
        if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
            return null;
        }

        if ($data['password'] !== $data['confirm_password']) {
            return null;
        }

        if ($this->userRepository->getUserByUsername($data['username'])) {
            return null;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $userData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $hashedPassword
        ];

        $res = $this->userRepository->insertUser($userData);

        var_dump($res);
        die;

        if ($res) {
            $userData['id'] = $res;
            $user = $this->userMapper->createUserFromArray($userData);
            return $user;
        } else {
            return null;
        }
    }

    public function loginUser(array $data): ?User
    {
        $userData = $this->userRepository->getUserByUsername($data['username']);
        if ($userData && password_verify($data['password'], $userData['password'])) {

            $user = $this->userMapper->createUserFromArray($userData);
            return $user;
        }
        return null;
    }
}
