<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogPostRequest;
use App\Http\Requests\Admin\UpdateBlogPostRequest;
use App\Models\BlogPost;
use App\Models\Category;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $query = BlogPost::query()->with(['category', 'user']);

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        $posts = $query
            ->orderByDesc('id')
            ->paginate((int) project('pagination_size', 15))
            ->withQueryString();

        $counts = [
            'all' => BlogPost::count(),
            'published' => BlogPost::where('is_published', true)->count(),
            'draft' => BlogPost::where('is_published', false)->count(),
        ];

        return view('admin.posts.index', compact('posts', 'status', 'counts'));
    }

    public function togglePublish(BlogPost $post): RedirectResponse
    {
        $newStatus = ! $post->is_published;
        $data = ['is_published' => $newStatus];

        if ($newStatus && ! $post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        $statusText = $newStatus ? 'published' : 'moved to drafts';

        return back()->with('toast_success', "Blog post is now {$statusText}.");
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data['user_id'] = auth()->id();
        $data['slug'] = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('title'));

        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = PublicUpload::storeImage($request->file('cover_image'), 'blog/covers');
        }

        BlogPost::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('toast_success', 'Blog post saved.');
    }

    public function edit(BlogPost $post): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $post): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data['slug'] = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('title'));

        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = $post->published_at ?: now();
        }

        if ($request->hasFile('cover_image')) {
            PublicUpload::delete($post->cover_image);
            $data['cover_image'] = PublicUpload::storeImage($request->file('cover_image'), 'blog/covers');
        }

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('toast_success', 'Blog post updated.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        PublicUpload::delete($post->cover_image);
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('toast_success', 'Blog post deleted.');
    }
}
