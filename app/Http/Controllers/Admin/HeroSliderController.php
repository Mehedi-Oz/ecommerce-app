<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSliderStoreRequest;
use App\Http\Requests\Admin\HeroSliderUpdateRequest;
use App\Models\HeroSlider;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HeroSliderController extends Controller
{
    use FileUpload;

    public function create(): View
    {
        return view('admin.hero-sliders.create');
    }

    public function store(HeroSliderStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->uploadFile($request->file('background_image'), 'sliders');
        }

        HeroSlider::create($data);
        NotificationService::created();

        return redirect()->route('admin.hero-sliders.index');
    }

    public function index(): View
    {
        $sliders = HeroSlider::ordered()->get();

        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function edit(HeroSlider $heroSlider): View
    {
        return view('admin.hero-sliders.edit', ['slider' => $heroSlider]);
    }

    public function update(HeroSliderUpdateRequest $request, HeroSlider $heroSlider): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('background_image')) {
            if ($heroSlider->background_image) {
                $this->deleteFile($heroSlider->background_image);
            }

            $data['background_image'] = $this->uploadFile($request->file('background_image'), 'sliders');
        }

        $heroSlider->fill($data);

        if (! $heroSlider->isDirty()) {
            return redirect()->route('admin.hero-sliders.edit', $heroSlider);
        }

        $heroSlider->save();
        NotificationService::updated();

        return redirect()->route('admin.hero-sliders.index');
    }

    public function destroy(HeroSlider $heroSlider): RedirectResponse
    {
        if ($heroSlider->background_image) {
            $this->deleteFile($heroSlider->background_image);
        }

        $heroSlider->delete();
        NotificationService::deleted();

        return redirect()->route('admin.hero-sliders.index');
    }

    public function toggleStatus(HeroSlider $heroSlider): RedirectResponse
    {
        $heroSlider->update([
            'is_active' => ! $heroSlider->is_active,
        ]);
        NotificationService::updated();

        return redirect()->route('admin.hero-sliders.index');
    }
}
