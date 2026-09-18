<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('blogPosts')
            ->orderBy('name')
            ->paginate((int) project('pagination_size', 15));

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $slug = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('name'));

        Category::create([
            'name' => $request->input('name'),
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('toast_success', 'Category saved.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $slug = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Str::slug($request->input('name'));

        $category->update([
            'name' => $request->input('name'),
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('toast_success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('toast_success', 'Category deleted.');
    }
}
