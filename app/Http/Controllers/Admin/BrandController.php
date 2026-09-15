<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandStoreRequest;
use App\Http\Requests\Admin\BrandUpdateRequest;
use App\Models\Brand;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    use FileUpload;

    public function create(): View
    {
        return view('admin.brand.create');
    }

    public function store(BrandStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'brands');
        }

        Brand::create($data);
        NotificationService::created();

        return redirect()->route('admin.brands.index');
    }

    public function index(): View
    {
        $brands = Brand::latest()->get();

        return view('admin.brand.index', compact('brands'));
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(BrandUpdateRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($brand->image) {
                $this->deleteFile($brand->image);
            }

            $data['image'] = $this->uploadFile($request->file('image'), 'brands');
        }

        $brand->fill($data);

        if (! $brand->isDirty()) {
            return redirect()->route('admin.brands.edit', $brand);
        }

        $brand->save();
        NotificationService::updated();

        return redirect()->route('admin.brands.index');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->image) {
            $this->deleteFile($brand->image);
        }

        $brand->delete();
        NotificationService::deleted();

        return redirect()->route('admin.brands.index');
    }

    public function toggleStatus(Brand $brand): RedirectResponse
    {
        $brand->update([
            'status' => $brand->status === 'published' ? 'unpublished' : 'published',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.brands.index');
    }
}
