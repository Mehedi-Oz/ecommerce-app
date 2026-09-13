<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function create(): View
    {
        return view('admin.category.create');
    }

    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        NotificationService::created();

        return redirect()->route('admin.category.manage');
    }

    public function manage(): View
    {
        $categories = Category::latest()->get();

        return view('admin.category.manage', compact('categories'));
    }

    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->fill($data);

        if (! $category->isDirty()) {
            return redirect()->route('admin.category.edit', $category->id);
        }

        $category->save();
        NotificationService::updated();

        return redirect()->route('admin.category.manage');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        NotificationService::deleted();

        return redirect()->route('admin.category.manage');
    }

    public function toggleStatus(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $category->update([
            'status' => $category->status === 'published' ? 'unpublished' : 'published',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.category.manage');
    }
}
