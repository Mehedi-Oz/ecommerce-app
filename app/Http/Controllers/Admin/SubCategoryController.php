<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryStoreRequest;
use App\Http\Requests\Admin\SubCategoryUpdateRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubCategoryController extends Controller
{
    use FileUpload;

    public function create(): View
    {
        $categories = Category::all();

        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(SubCategoryStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'subcategories');
        }

        SubCategory::create($data);
        NotificationService::created();

        return redirect()->route('admin.subcategories.index');
    }

    public function index(): View
    {
        $subCategories = SubCategory::with('category')->latest()->get();

        return view('admin.subcategory.index', compact('subCategories'));
    }

    public function edit(SubCategory $subcategory): View
    {
        $categories = Category::all();

        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(SubCategoryUpdateRequest $request, SubCategory $subcategory): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                $this->deleteFile($subcategory->image);
            }

            $data['image'] = $this->uploadFile($request->file('image'), 'subcategories');
        }

        $subcategory->fill($data);

        if (! $subcategory->isDirty()) {
            return redirect()->route('admin.subcategories.edit', $subcategory);
        }

        $subcategory->save();
        NotificationService::updated();

        return redirect()->route('admin.subcategories.index');
    }

    public function destroy(SubCategory $subcategory): RedirectResponse
    {
        if ($subcategory->image) {
            $this->deleteFile($subcategory->image);
        }

        $subcategory->delete();
        NotificationService::deleted();

        return redirect()->route('admin.subcategories.index');
    }

    public function toggleStatus(SubCategory $subcategory): RedirectResponse
    {
        $subcategory->update([
            'status' => $subcategory->status === 'published' ? 'unpublished' : 'published',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.subcategories.index');
    }
}
