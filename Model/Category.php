<?php

namespace Model;

use Engine\Constants;

class Category
{
    protected int $mainCategory = 0;
    protected int $subCategory = 0;
    protected string $mainCategoryName = '';
    protected string $subCategoryName = '';
    protected array $categoryNames = [];


    public function getMainCategory(): int
    {
        return $this->mainCategory;
    }
    public function getSubCategory(): int
    {
        return $this->subCategory;
    }
    public function getMainCategoryName(): string
    {
        return $this->mainCategoryName;
    }
    public function getSubCategoryName(): string
    {
        return $this->subCategoryName;
    }
    public function setMainCategory(int $mainCategory): void
    {
        $this->mainCategory = $mainCategory;
    }
    public function setSubCategory(int $subCategory): void
    {
        $this->subCategory = $subCategory;
    }
    public function setMainCategoryName(string $mainCategoryName): void
    {
        $this->mainCategoryName = $mainCategoryName;
    }
    public function setSubCategoryName(string $subCategoryName): void
    {
        $this->subCategoryName = $subCategoryName;
    }
}
