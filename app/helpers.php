<?php

use App\Enums\ProductAttributesEnum;

if (!function_exists('get_product_sizes')) {
    /**
     * Get all available product sizes
     */
    function get_product_sizes(): array
    {
        return ProductAttributesEnum::getSizes();
    }
}

if (!function_exists('get_product_colors')) {
    /**
     * Get all available product colors
     */
    function get_product_colors(): array
    {
        return ProductAttributesEnum::getColors();
    }
}

if (!function_exists('get_product_color_names')) {
    /**
     * Get all available product color names
     */
    function get_product_color_names(): array
    {
        return ProductAttributesEnum::getColorNames();
    }
}

if (!function_exists('get_color_code')) {
    /**
     * Get color hex code by color name
     *
     * @param string $colorName Color name (e.g., 'Đỏ', 'Xanh dương')
     * @return string|null Color hex code (e.g., '#FF0000') or null if not found
     */
    function get_color_code(string $colorName): ?string
    {
        return ProductAttributesEnum::getColorCode($colorName);
    }
}

if (!function_exists('get_color_details')) {
    /**
     * Get color details (name and code) by color name
     *
     * @param string $colorName Color name
     * @return array|null Array with 'name' and 'code' keys, or null if not found
     */
    function get_color_details(string $colorName): ?array
    {
        return ProductAttributesEnum::getColorDetails($colorName);
    }
}
