<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post;
use App\Models\Blog\Category;
use App\Models\Blog\Author;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display blog index page
     */
    public function index(Request $request): View
    {
        $query = Post::with(['author', 'category', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->get('category'));
        }

        $posts = $query->paginate(6);

        // Get categories for sidebar
        $categories = Category::where('is_visible', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Post::with(['author', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    /**
     * Display blog left sidebar page
     */
    public function leftSidebar(Request $request): View
    {
        $query = Post::with(['author', 'category', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->get('category'));
        }

        $posts = $query->paginate(6);

        // Get categories for sidebar
        $categories = Category::where('is_visible', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Post::with(['author', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('blog.left-sidebar', compact('posts', 'categories', 'recentPosts'));
    }

    /**
     * Display blog right sidebar page
     */
    public function rightSidebar(Request $request): View
    {
        $query = Post::with(['author', 'category', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->get('category'));
        }

        $posts = $query->paginate(6);

        // Get categories for sidebar
        $categories = Category::where('is_visible', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Post::with(['author', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('blog.right-sidebar', compact('posts', 'categories', 'recentPosts'));
    }

    /**
     * Display blog post details
     */
    public function details(Request $request, $slug = null): View
    {
        // Get a sample post for demo if no slug provided
        $post = $slug ?
            Post::with(['author', 'category', 'media', 'tags'])->where('slug', $slug)->firstOrFail() :
            Post::with(['author', 'category', 'media', 'tags'])->whereNotNull('published_at')->first();

        // Get related posts
        $relatedPosts = Post::with(['author', 'media'])
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->limit(3)
            ->get();

        // Get categories for sidebar
        $categories = Category::where('is_visible', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Post::with(['author', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Get total posts count
        $totalPosts = Post::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->count();

        // Get popular tags for sidebar (if tags relationship exists)
        $popularTags = collect(); // Initialize as empty collection
        try {
            if (class_exists('\Spatie\Tags\Tag')) {
                $popularTags = \Spatie\Tags\Tag::withCount('posts')
                    ->orderBy('posts_count', 'desc')
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            // Tags not available, continue with empty collection
        }

        return view('blog.details', compact('post', 'relatedPosts', 'categories', 'recentPosts', 'totalPosts', 'popularTags'));
    }

    /**
     * Display blog post details with left sidebar
     */
    public function detailsLeft(Request $request, $slug = null): View
    {
        // Get a sample post for demo if no slug provided
        $post = $slug ?
            Post::with(['author', 'category', 'media'])->where('slug', $slug)->firstOrFail() :
            Post::with(['author', 'category', 'media'])->whereNotNull('published_at')->first();

        // Get related posts
        $relatedPosts = Post::with(['author', 'media'])
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->limit(3)
            ->get();

        // Get categories for sidebar
        $categories = Category::where('is_visible', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Post::with(['author', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('blog.details-left', compact('post', 'relatedPosts', 'categories', 'recentPosts'));
    }

    /**
     * Display blog post details with right sidebar
     */
    public function detailsRight(Request $request, $slug = null): View
    {
        // Get a sample post for demo if no slug provided
        $post = $slug ?
            Post::with(['author', 'category', 'media'])->where('slug', $slug)->firstOrFail() :
            Post::with(['author', 'category', 'media'])->whereNotNull('published_at')->first();

        // Get related posts
        $relatedPosts = Post::with(['author', 'media'])
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->limit(3)
            ->get();

        // Get categories for sidebar
        $categories = Category::where('is_visible', true)
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        // Get recent posts for sidebar
        $recentPosts = Post::with(['author', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('blog.details-right', compact('post', 'relatedPosts', 'categories', 'recentPosts'));
    }
}
