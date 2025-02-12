<?php

namespace Service;

class PaginationService
{
    public function paginate(array $allItems, int $page = 1, int $itemsPerPage = 10): array
    {
        $offset = ($page - 1) * $itemsPerPage;
        $pagedItems = array_slice($allItems, $offset, $itemsPerPage);
        $totalItems = count($allItems);
        $hasMoreItems = $totalItems > ($offset + $itemsPerPage);
        $lastPage = (int) ceil($totalItems / $itemsPerPage);
        $lastPage = $lastPage > 0 ? $lastPage : 1;

        return [
            'items' => $pagedItems,
            'hasMoreItems' => $hasMoreItems,
            'nextPage' => $page + 1,
            'currentPage' => $page,
            'lastPage' => $lastPage,
            'itemsPerPage' => $itemsPerPage
        ];
    }
}