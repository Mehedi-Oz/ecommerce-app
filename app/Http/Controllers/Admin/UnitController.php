<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitStoreRequest;
use App\Http\Requests\Admin\UnitUpdateRequest;
use App\Models\Unit;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    public function create(): View
    {
        return view('admin.units.create');
    }

    public function store(UnitStoreRequest $request): RedirectResponse
    {
        Unit::create($request->validated());
        NotificationService::created();

        return redirect()->route('admin.units.index');
    }

    public function index(): View
    {
        $units = Unit::latest()->get();

        return view('admin.units.index', compact('units'));
    }

    public function edit(Unit $unit): View
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(UnitUpdateRequest $request, Unit $unit): RedirectResponse
    {
        $unit->fill($request->validated());

        if (! $unit->isDirty()) {
            return redirect()->route('admin.units.edit', $unit);
        }

        $unit->save();
        NotificationService::updated();

        return redirect()->route('admin.units.index');
    }

    public function destroy(Unit $unit): RedirectResponse
    {
        $unit->delete();
        NotificationService::deleted();

        return redirect()->route('admin.units.index');
    }

    public function toggleStatus(Unit $unit): RedirectResponse
    {
        $unit->update([
            'status' => $unit->status === 'published' ? 'unpublished' : 'published',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.units.index');
    }
}
