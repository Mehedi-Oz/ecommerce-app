<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use FileUpload;
    use PasswordValidationRules;

    public function edit(Request $request): View
    {
        $admin = $request->user('admin');

        return view('admin.profile.edit', [
            'admin' => $admin,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $admin = $request->user('admin');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($admin->image) {
                $this->deleteFile($admin->image);
            }

            $admin->image = $this->uploadFile($request->file('image'), 'admins');
        }

        $admin->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ])->save();

        NotificationService::updated(__('Profile updated successfully.'));

        return redirect()->route('admin.profile.edit');
    }

    public function editPassword(): View
    {
        return view('admin.profile.password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password:admin'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ]);

        $request->user('admin')->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        NotificationService::updated(__('Password changed successfully.'));

        return redirect()->route('admin.password.edit');
    }
}
