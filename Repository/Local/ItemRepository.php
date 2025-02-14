<?php

namespace Repository\Local;

class ItemRepository extends AbstractLocalRepository
{
    public function getItemById(int $id): ?array
    {
        $sql = "SELECT * FROM item WHERE id = :id";
        return $this->query($sql, ['id' => $id]);
    }

    public function getItemsByCategoryData(array $data): ?array
    {
        $items = [];

        foreach ($data as $category) {
            $sql = "SELECT * FROM item WHERE categoryMain = :mainCategory AND categorySub = :subCategory";
            $response = $this->queryAll($sql, $category);
            $items[] = $response ? $response : null;
        }

        $flattened = [];
        foreach ($items as $subArray) {
            foreach ($subArray as $element) {
                $flattened[] = $element;
            }
        }


        return $flattened;
    }

    public function getAllItems(): ?array
    {
        $sql = "SELECT * FROM item";
        return $this->queryAll($sql);
    }

    public function insertItem(array $data): ?int
    {
        $sql = "INSERT IGNORE INTO item (id, name, image, categoryMain, categorySub) 
                VALUES (:id, :name, :image, :categoryMain, :categorySub)";
        return $this->insert($sql, $data);
    }

    public function updateItem(int $id, array $data): int
    {
        $sql = "UPDATE item 
                SET name = :name, image = :image, categoryId = :categoryId 
                WHERE id = :id";
        $data['id'] = $id;
        return $this->update($sql, $data);
    }

    public function deleteItem(int $id): int
    {
        $sql = "DELETE FROM item WHERE id = :id";
        return $this->delete($sql, ['id' => $id]);
    }
}
