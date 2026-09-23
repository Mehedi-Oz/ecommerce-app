<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FlashDealStoreRequest;
use App\Http\Requests\Admin\FlashDealUpdateRequest;
use App\Models\FlashDeal;
use App\Models\Product;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FlashDealController extends Controller
{
    public function create(): View
    {
        return view('admin.flash-deals.create', [
            'products' => Product::published()->latest()->take(100)->get(),
        ]);
    }

    public function store(FlashDealStoreRequest $request): RedirectResponse
    {
        FlashDeal::create($request->validated());
        NotificationService::created();

        return redirect()->route('admin.flash-deals.index');
    }

    public function index(): View
    {
        $deals = FlashDeal::with('product')->latest()->get();

        return view('admin.flash-deals.index', compact('deals'));
    }

    public function edit(FlashDeal $flashDeal): View
    {
        return view('admin.flash-deals.edit', [
            'deal' => $flashDeal,
            'products' => Product::published()->latest()->take(100)->get(),
        ]);
    }

    public function update(FlashDealUpdateRequest $request, FlashDeal $flashDeal): RedirectResponse
    {
        $flashDeal->fill($request->validated());

        if (! $flashDeal->isDirty()) {
            return redirect()->route('admin.flash-deals.edit', $flashDeal);
        }

        $flashDeal->save();
        NotificationService::updated();

        return redirect()->route('admin.flash-deals.index');
    }

    public function destroy(FlashDeal $flashDeal): RedirectResponse
    {
        $flashDeal->delete();
        NotificationService::deleted();

        return redirect()->route('admin.flash-deals.index');
    }

    public function toggleStatus(FlashDeal $flashDeal): RedirectResponse
    {
        $flashDeal->update([
            'is_active' => ! $flashDeal->is_active,
        ]);
        NotificationService::updated();

        return redirect()->route('admin.flash-deals.index');
    }
}
