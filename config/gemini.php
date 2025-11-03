<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gemini API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google's Gemini AI API integration
    |
    */

    'api_key' => env('GEMINI_API_KEY'),
    'api_url' => env('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent'),
    'model' => env('GEMINI_MODEL', 'gemini-pro'),
    'max_tokens' => env('GEMINI_MAX_TOKENS', 1000),
    'temperature' => env('GEMINI_TEMPERATURE', 0.7),
];