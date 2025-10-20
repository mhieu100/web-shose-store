<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post;
use App\Models\Blog\Author;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the about page
     */
    public function index(): View
    {
        // Get team members (using blog authors as team members for now)
        $teamMembers = Author::orderBy('name')
            ->limit(4)
            ->get();

        // Get latest blog posts for the blog section
        $latestPosts = Post::with(['author', 'category', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Sample testimonials data (could be moved to database later)
        $testimonials = [
            [
                'name' => 'Anh Minh Hoàng',
                'content' => 'Chất lượng giày rất tốt, đi rất êm chân và bền. Tôi đã mua nhiều đôi ở đây và luôn hài lòng với chất lượng sản phẩm.',
                'image' => 'img/testimonial/1.webp',
                'position' => 'Khách hàng thân thiết'
            ],
            [
                'name' => 'Chị Hương Lan',
                'content' => 'Dịch vụ chăm sóc khách hàng tuyệt vời, nhân viên tư vấn nhiệt tình và chu đáo. Giao hàng nhanh và đóng gói cẩn thận.',
                'image' => 'img/testimonial/2.webp',
                'position' => 'Khách hàng VIP'
            ]
        ];

        return view('pages.about', compact('teamMembers', 'latestPosts', 'testimonials'));
    }
}