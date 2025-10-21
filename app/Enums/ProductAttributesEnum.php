<?php

namespace App\Enums;

class ProductAttributesEnum
{
    /**
     * Available product sizes
     */
    public const SIZES = [
        // Giày dép - Shoe sizes
        '35' => '35',
        '36' => '36',
        '37' => '37',
        '38' => '38',
        '39' => '39',
        '40' => '40',
        '41' => '41',
        '42' => '42',
        '43' => '43',
        '44' => '44',
        '45' => '45',
        '46' => '46',
    ];

    /**
     * Available product colors with their hex codes
     */
    public const COLORS = [
        'Đen' => ['name' => 'Đen', 'code' => '#000000'],
        'Trắng' => ['name' => 'Trắng', 'code' => '#FFFFFF'],
        'Xám' => ['name' => 'Xám', 'code' => '#808080'],
        'Xám nhạt' => ['name' => 'Xám nhạt', 'code' => '#D3D3D3'],

        'Đỏ' => ['name' => 'Đỏ', 'code' => '#FF0000'],
        'Đỏ tía' => ['name' => 'Đỏ tía', 'code' => '#DC143C'],
        'Đỏ rượu' => ['name' => 'Đỏ rượu', 'code' => '#800020'],

        'Hồng' => ['name' => 'Hồng', 'code' => '#FFC0CB'],
        'Hồng nhạt' => ['name' => 'Hồng nhạt', 'code' => '#FFB6C1'],
        'Hồng đậm' => ['name' => 'Hồng đậm', 'code' => '#FF1493'],

        'Cam' => ['name' => 'Cam', 'code' => '#FFA500'],
        'Cam đất' => ['name' => 'Cam đất', 'code' => '#FF8C00'],

        'Vàng' => ['name' => 'Vàng', 'code' => '#FFFF00'],
        'Vàng gold' => ['name' => 'Vàng gold', 'code' => '#FFD700'],
        'Vàng nhạt' => ['name' => 'Vàng nhạt', 'code' => '#FFFACD'],

        'Xanh lá' => ['name' => 'Xanh lá', 'code' => '#008000'],
        'Xanh lá cây' => ['name' => 'Xanh lá cây', 'code' => '#228B22'],
        'Xanh lá nhạt' => ['name' => 'Xanh lá nhạt', 'code' => '#90EE90'],
        'Xanh lá đậm' => ['name' => 'Xanh lá đậm', 'code' => '#006400'],
        'Xanh rêu' => ['name' => 'Xanh rêu', 'code' => '#556B2F'],

        'Xanh dương' => ['name' => 'Xanh dương', 'code' => '#0000FF'],
        'Xanh navy' => ['name' => 'Xanh navy', 'code' => '#000080'],
        'Xanh da trời' => ['name' => 'Xanh da trời', 'code' => '#87CEEB'],
        'Xanh biển' => ['name' => 'Xanh biển', 'code' => '#4682B4'],
        'Xanh ngọc' => ['name' => 'Xanh ngọc', 'code' => '#40E0D0'],
        'Xanh cyan' => ['name' => 'Xanh cyan', 'code' => '#00FFFF'],

        'Tím' => ['name' => 'Tím', 'code' => '#800080'],
        'Tím lavender' => ['name' => 'Tím lavender', 'code' => '#E6E6FA'],
        'Tím than' => ['name' => 'Tím than', 'code' => '#4B0082'],

        'Nâu' => ['name' => 'Nâu', 'code' => '#A52A2A'],
        'Nâu đất' => ['name' => 'Nâu đất', 'code' => '#8B4513'],
        'Nâu nhạt' => ['name' => 'Nâu nhạt', 'code' => '#D2B48C'],
        'Nâu cafe' => ['name' => 'Nâu cafe', 'code' => '#6F4E37'],

        'Be' => ['name' => 'Be', 'code' => '#F5F5DC'],
        'Kem' => ['name' => 'Kem', 'code' => '#FFFDD0'],

        'Bạc' => ['name' => 'Bạc', 'code' => '#C0C0C0'],
        'Vàng gold metallic' => ['name' => 'Vàng gold metallic', 'code' => '#D4AF37'],
    ];

    /**
     * Get all available sizes
     */
    public static function getSizes(): array
    {
        return self::SIZES;
    }

    /**
     * Get all available colors (names only)
     */
    public static function getColorNames(): array
    {
        return array_keys(self::COLORS);
    }

    /**
     * Get all available colors with details
     */
    public static function getColors(): array
    {
        return self::COLORS;
    }

    /**
     * Get color code by name
     */
    public static function getColorCode(string $colorName): ?string
    {
        return self::COLORS[$colorName]['code'] ?? null;
    }

    /**
     * Get color details by name
     */
    public static function getColorDetails(string $colorName): ?array
    {
        return self::COLORS[$colorName] ?? null;
    }
}
