<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::query()
            ->with(['category', 'user'])
            ->published()
            ->ordered();

        $currentCategory = null;
        if ($request->filled('category')) {
            $currentCategory = Category::where('slug', $request->query('category'))->first();
            if ($currentCategory) {
                $query->where('category_id', $currentCategory->id);
            }
        }

        $posts = $query->paginate((int) project('pagination_size', 9))->withQueryString();

        $categories = Category::query()
            ->whereHas('blogPosts', fn ($q) => $q->published())
            ->withCount(['blogPosts' => fn ($q) => $q->published()])
            ->orderBy('name')
            ->get();

        return view('blog.index', compact('posts', 'categories', 'currentCategory'));
    }

    public function show(BlogPost $post): View
    {
        if (! $post->is_published && ! auth()->user()?->is_admin) {
            abort(404);
        }

        $recentPosts = BlogPost::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'recentPosts'));
    }
}
