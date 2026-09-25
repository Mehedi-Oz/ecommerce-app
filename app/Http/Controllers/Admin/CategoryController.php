<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    use FileUpload;

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['is_featured']) && Category::featuredLimitReached()) {
            NotificationService::error(__('Only :count categories can be featured at a time.', ['count' => Category::MAX_FEATURED]));

            return redirect()->back()->withInput();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'categories');
        }

        Category::create($data);
        NotificationService::created();

        return redirect()->route('admin.categories.index');
    }

    public function index(): View
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['is_featured']) && Category::featuredLimitReached($category)) {
            NotificationService::error(__('Only :count categories can be featured at a time.', ['count' => Category::MAX_FEATURED]));

            return redirect()->back()->withInput();
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                $this->deleteFile($category->image);
            }

            $data['image'] = $this->uploadFile($request->file('image'), 'categories');
        }

        $category->fill($data);

        if (! $category->isDirty()) {
            return redirect()->route('admin.categories.edit', $category);
        }

        $category->save();
        NotificationService::updated();

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->image) {
            $this->deleteFile($category->image);
        }

        $category->delete();
        NotificationService::deleted();

        return redirect()->route('admin.categories.index');
    }

    public function toggleStatus(Category $category): RedirectResponse
    {
        $category->update([
            'status' => $category->status === 'published' ? 'unpublished' : 'published',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.categories.index');
    }

    public function toggleFeatured(Category $category): RedirectResponse
    {
        if (! $category->is_featured && Category::featuredLimitReached()) {
            NotificationService::error(__('Only :count categories can be featured at a time.', ['count' => Category::MAX_FEATURED]));

            return redirect()->route('admin.categories.index');
        }

        $category->update([
            'is_featured' => ! $category->is_featured,
        ]);
        NotificationService::updated();

        return redirect()->route('admin.categories.index');
    }
}
