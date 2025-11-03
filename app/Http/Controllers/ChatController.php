<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiChatService;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    private GeminiChatService $geminiService;

    public function __construct(GeminiChatService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Handle chat message from user
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'context' => 'sometimes|array'
        ]);

        $message = $request->input('message');
        $context = $request->input('context', []);

        // Add session-based context
        $context['session_id'] = session()->getId();
        
        $response = $this->geminiService->generateResponse($message, $context);

        // Get product recommendations if relevant
        $recommendations = [];
        if (stripos($message, 'giày') !== false || stripos($message, 'sản phẩm') !== false) {
            $recommendations = $this->geminiService->getProductRecommendations($message);
        }

        return response()->json([
            'success' => true,
            'response' => $response,
            'recommendations' => $recommendations,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Get quick suggestions for common questions
     */
    public function getQuickSuggestions(): JsonResponse
    {
        $suggestions = [
            'Tôi muốn tìm giày thể thao nam',
            'Giày cao gót nữ có những loại nào?',
            'Cách chọn size giày phù hợp',
            'Chính sách đổi trả như thế nào?',
            'Thời gian giao hàng bao lâu?',
            'Có khuyến mãi gì không?'
        ];

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    }

    /**
     * Get chat context based on current page
     */
    public function getContext(Request $request): JsonResponse
    {
        $context = [];
        
        if ($request->has('product_id')) {
            $context['current_product'] = $request->input('product_id');
        }
        
        if ($request->has('category_id')) {
            $context['current_category'] = $request->input('category_id');
        }
        
        // Add cart context from session
        $cart = session()->get('cart', []);
        $context['cart_items'] = array_keys($cart);

        return response()->json([
            'success' => true,
            'context' => $context
        ]);
    }
}