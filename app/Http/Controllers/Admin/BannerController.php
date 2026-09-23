<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerStoreRequest;
use App\Http\Requests\Admin\BannerUpdateRequest;
use App\Models\Banner;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BannerController extends Controller
{
    use FileUpload;

    public function create(): View
    {
        return view('admin.banners.create', [
            'locations' => Banner::LOCATIONS,
        ]);
    }

    public function store(BannerStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'banners');
        }

        Banner::create($data);
        NotificationService::created();

        return redirect()->route('admin.banners.index');
    }

    public function index(): View
    {
        $banners = Banner::ordered()->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', [
            'banner' => $banner,
            'locations' => Banner::LOCATIONS,
        ]);
    }

    public function update(BannerUpdateRequest $request, Banner $banner): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($banner->image) {
                $this->deleteFile($banner->image);
            }

            $data['image'] = $this->uploadFile($request->file('image'), 'banners');
        }

        $banner->fill($data);

        if (! $banner->isDirty()) {
            return redirect()->route('admin.banners.edit', $banner);
        }

        $banner->save();
        NotificationService::updated();

        return redirect()->route('admin.banners.index');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image) {
            $this->deleteFile($banner->image);
        }

        $banner->delete();
        NotificationService::deleted();

        return redirect()->route('admin.banners.index');
    }

    public function toggleStatus(Banner $banner): RedirectResponse
    {
        $banner->update([
            'is_active' => ! $banner->is_active,
        ]);
        NotificationService::updated();

        return redirect()->route('admin.banners.index');
    }
}
