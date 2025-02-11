<?php

namespace Service;

use Config\Constants;
use Service\CacheService;
use Model\ItemMapper;
use Model\Item;

class ItemService
{
    protected ?ApiService $apiService = null;
    protected ?ItemMapper $itemMapper = null;
    protected ?CacheService $cacheService = null;

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->itemMapper = new ItemMapper();
        $this->cacheService = new CacheService();
    }

    public function getItemsFromCategory(array $categoryData, array $itemNames = []): array
    {
        $items = $this->getAllItemsFromCategory($categoryData);

        if ($itemNames) {
            return $this->getSpecificItemsFromCategory($items, $itemNames);
        } else {
            return $items;
        }
    }
    public function addMarketInfoToItems(array $items): array
    {
        foreach ($items as $key => $item) {
            $itemIds[] = $item->getItemId();
        }

        $marketData = $this->apiService->fetchMultipleItemData($itemIds);

        foreach ($items as $key => $item) {
            $newItems[] = $this->itemMapper->addMarketInfo($item, $marketData[$item->getItemId()]);
        }

        return $newItems;
    }

    // Only temporary since later you'll get Items by ID instead of searching through categories
    public function getSpecificItemsFromCategory(array $items, array $itemNames): array
    {
        $itemsFiltered = [];

        foreach ($items as $item) {
            if (in_array($item->getItemName(), $itemNames)) {

                $itemsFiltered[] = $item;
            }
        }
        return $itemsFiltered;
    }

    public function getAllItemsFromCategory(array $categoryData): array
    {
        // Ohne MarketInfo holen
        $data = $this->apiService->fetchItemsFromCategory(
            $categoryData,
            false
        );
        $items = [];

        $nonCachedItems = [];
        foreach ($data as $key => &$item) {
            $itemId = $item['id'];

            if ($this->cacheService->isImageInCache($itemId)) {
                // Bild aus dem Cache verwenden
                $item['itemImage'] = Constants::DIR_ICONS_CACHE . $itemId . '.webp';
            } else {
                // Für diesen Item wird später ein Request gestartet – merke Dir den Index
                $nonCachedItems[$itemId] = $key;
            }
        }
        unset($item); // Referenz löschen

        // Schritt 2: Für alle Items, die nicht im Cache liegen, parallele HTTP-Requests starten
        if (!empty($nonCachedItems)) {
            // Alle betroffenen Item-IDs ermitteln
            $nonCachedIds = array_keys($nonCachedItems);

            // Mit Multi‑cURL die Bilder abrufen – diese Methode gibt ein Array zurück: [itemId => imgUrl|null]
            $fetchedImages = $this->apiService->fetchItemsImages($nonCachedIds);

            // Ergebnisse durchgehen
            foreach ($fetchedImages as $itemId => $imgUrl) {
                if ($imgUrl) {
                    // Bild im Cache speichern, wenn ein Bild zurückgegeben wurde
                    $this->cacheService->saveImageToCache($imgUrl, $itemId);
                } else {
                    // Falls kein Bild gefunden wurde, den Platzhalter nutzen
                    $imgUrl = Constants::DIR_ICONS_PLACEHOLDER;
                }
                // Das Ergebnis an der entsprechenden Stelle im ursprünglichen Array zuweisen
                $key = $nonCachedItems[$itemId];
                $data[$key]['itemImage'] = $imgUrl;
            }
        }

        // Schritt 3: Alle Items in die finalen Item-Objekte umwandeln
        $items = [];
        foreach ($data as $item) {
            $itemObj = $this->itemMapper->createItemFromArray($item);
            $items[] = $itemObj;
        }
        return $items;
    }
}