<?php

namespace Repository\Local;

class UserRepository extends AbstractLocalRepository
{
    public function getUserById(int $id): ?array
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        return $this->query($sql, ['id' => $id]);
    }

    public function getUserByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM user WHERE username = :username";
        return $this->query($sql, ['username' => $username]);
    }

    public function insertUser(array $data): ?int
    {
        $sql = "INSERT INTO user (username, password) 
                VALUES (:username, :password)";
        return $this->insert($sql, $data);
    }

    public function updateUser(int $id, array $data): int
    {
        $sql = "UPDATE user 
                SET username = :username, password = :password 
                WHERE id = :id";
        $data['id'] = $id;
        return $this->update($sql, $data);
    }

    public function deleteUser(int $id): int
    {
        $sql = "DELETE FROM user WHERE id = :id";
        return $this->delete($sql, ['id' => $id]);
    }
}
