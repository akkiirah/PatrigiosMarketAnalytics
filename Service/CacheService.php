<?php

namespace Service;

use Config\Constants;

class CacheService
{
    public function saveImageToCache(string $imgUrl, int $itemId): ?string
    {
        $cacheDir = __DIR__ . '/..' . Constants::DIR_ICONS_CACHE;
        $imagePath = $cacheDir . $itemId . '.webp';

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $imgData = file_get_contents($imgUrl);
        if (!$imgData) {
            return null;
        }

        file_put_contents($imagePath, $imgData);

        return Constants::DIR_ICONS_CACHE . $itemId . '.webp';
    }

    public function isImageInCache(int $itemId): bool
    {
        $cacheDir = __DIR__ . '/..' . Constants::DIR_ICONS_CACHE;
        $imagePath = $cacheDir . $itemId . '.webp';

        return file_exists($imagePath);
    }
}
