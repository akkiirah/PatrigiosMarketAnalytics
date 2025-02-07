<?php

namespace Model;

use Engine\Constants;

class CategoryMapper
{
    protected array $categories = [];

    public function __construct()
    {
        $json = file_get_contents(Constants::DIR_CATEGORIES_JSON);
        $categoryArray = json_decode($json, true);
        $this->categories = $categoryArray;
    }

    public function createCategoryFromArray(array $dataArray): Category
    {
        $mainCategoryName = $this->categories['mainCategories'][$dataArray['mainCategory']];
        $subCategoryName = $this->categories['subCategories'][$dataArray['mainCategory']][$dataArray['subCategory']];

        $category = new Category();
        $category->setMainCategory($dataArray['mainCategory']);
        $category->setSubCategory($dataArray['subCategory']);
        $category->setMainCategoryName($mainCategoryName);
        $category->setSubCategoryName($subCategoryName);

        return $category;
    }
}