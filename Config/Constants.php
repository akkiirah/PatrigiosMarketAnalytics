<?php

namespace Config;

class Constants
{
    public const DIR_CACHE = 'Cache/templates';
    public const DIR_TEMPLATES = 'Resources/html/templates/';
    public const DIR_CATEGORIES_JSON = 'Resources/json/categories.json';
    public const DIR_ICONS_CACHE = '/Cache/icons/';
    public const DIR_ICONS_PLACEHOLDER = '/Resources/assets/placeholder/item-placeholder.webp';

    public const API_CATEGORY_URL = 'https://api.arsha.io/v2/eu/category?lang=en';
    public const API_ITEM_DETAIL_URL = 'https://api.arsha.io/v2/eu/GetWorldMarketSubList';
    public const API_ITEM_PRICE_HISTORY_URL = 'https://api.arsha.io/v1/eu/GetMarketPriceInfo';

    public const IMG_API_URL = 'https://bdocodex.com/';
    public const IMG_URL = self::IMG_API_URL . 'en/item/';
}