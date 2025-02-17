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

        if (!empty($items) && isset($items[0]) && is_array($items[0])) {
            $flattened = [];
            foreach ($items as $subArray) {
                if (is_array($subArray)) {
                    foreach ($subArray as $element) {
                        $flattened[] = $element;
                    }
                } else {
                    $flattened[] = $subArray;
                }
            }
        } else {
            $flattened = $items;
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
        $sql = "INSERT INTO item (id, sid, name, image, categoryMain, categorySub) 
                VALUES (:id, :sid, :name, :image, :categoryMain, :categorySub)";
        return $this->insert($sql, $data);
    }

    public function updateItem(array $data): int
    {
        $sql = "UPDATE item 
                SET sid = :sid, name = :name, image = :image, categoryMain = :categoryMain, categorySub = :categorySub
                WHERE id = :id";
        return $this->update($sql, $data);
    }

    public function deleteItem(int $id): int
    {
        $sql = "DELETE FROM item WHERE id = :id";
        return $this->delete($sql, ['id' => $id]);
    }
}
