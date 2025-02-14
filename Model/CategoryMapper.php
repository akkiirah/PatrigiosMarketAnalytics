<?php

namespace Model;

use Config\Constants;

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
        // Bestimme den richtigen Schlüssel für die Haupt- und Unterkategorie
        $mainKey = isset($dataArray['mainCategory']) ? 'mainCategory' : 'categoryMain';
        $subKey = isset($dataArray['subCategory']) ? 'subCategory' : 'categorySub';

        // Hole die Werte aus dem Array
        $mainCategoryValue = $dataArray[$mainKey];
        $subCategoryValue = $dataArray[$subKey];

        // Ermittle die Namen anhand der Kategorien-Konfiguration
        $mainCategoryName = $this->categories['mainCategories'][$mainCategoryValue];
        $subCategoryName = $this->categories['subCategories'][$mainCategoryValue][$subCategoryValue];

        // Erstelle und befülle das Category-Objekt
        $category = new Category();
        $category->setMainCategory($mainCategoryValue);
        $category->setSubCategory($subCategoryValue);
        $category->setMainCategoryName($mainCategoryName);
        $category->setSubCategoryName($subCategoryName);

        return $category;
    }
}