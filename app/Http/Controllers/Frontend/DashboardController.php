<?php

namespace App\Http\Controllers\Frontend;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Rules\BangladeshiPhoneNumber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardController extends Controller
{
    use PasswordValidationRules;

    public function index(Request $request): View
    {
        $user = $request->user();

        $orders = $user->orders()->latest()->withCount('details as items_count')->take(5)->get();

        return view('frontend.dashboard.index', [
            'user' => $user,
            'photoUrl' => $this->photoUrl($user),
            'totalOrders' => $user->orders()->count(),
            'pendingOrders' => $user->orders()->where('order_status', 'pending')->count(),
            'totalSpent' => (float) $user->orders()->sum('order_total'),
            'recentOrders' => $orders,
            'orderNumbers' => $this->orderNumbers($user),
        ]);
    }

    public function orders(Request $request): View
    {
        $status = $request->query('status');
        $statusFilter = in_array($status, ['pending', 'processing', 'completed', 'cancelled'], true) ? $status : null;

        $orders = $request->user()->orders()
            ->latest()
            ->withCount('details as items_count')
            ->when($statusFilter !== null, fn ($query) => $query->where('order_status', $statusFilter))
            ->paginate(10)
            ->withQueryString();

        return view('frontend.dashboard.orders', [
            'orders' => $orders,
            'orderNumbers' => $this->orderNumbers($request->user()),
            'statusFilter' => $statusFilter,
            'statusOptions' => ['pending', 'processing', 'completed', 'cancelled'],
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        abort_if($order->user_id !== $request->user()->id, 404);

        $order->load(['details', 'user']);
        $orderNumbers = $this->orderNumbers($request->user());

        $updateNotes = $order->histories()
            ->whereNotNull('note')
            ->where('note', '<>', '')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->groupBy(fn ($history): string => $history->created_at->format('Y-m-d H:i').' '.$history->note);

        return view('frontend.dashboard.show', [
            'order' => $order,
            'orderNumber' => $orderNumbers[$order->id] ?? $order->id,
            'updateNotes' => $updateNotes,
        ]);
    }

    public function profile(Request $request): View
    {
        $user = $request->user();

        return view('frontend.dashboard.profile', [
            'user' => $user,
            'photoUrl' => $this->photoUrl($user),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20', new BangladeshiPhoneNumber, Rule::unique('users')->ignore($user->id)],
            'address' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'nid' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->image !== null) {
                Storage::delete($user->image);
            }

            $user->image = $request->file('photo')->store('profile-photos');
        } elseif ($request->boolean('remove_photo') && $user->image !== null) {
            Storage::delete($user->image);
            $user->image = null;
        }

        unset($validated['photo'], $validated['remove_photo']);

        $user->fill($validated)->save();

        return redirect()->route('dashboard.profile')->with('status', __('Profile updated successfully.'));
    }

    private function orderNumbers(User $user): array
    {
        return $user->orders()
            ->orderBy('created_at')
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn (int $id, int $index): array => [$id => $index + 1])
            ->all();
    }

    public function photo(Request $request, User $user): BinaryFileResponse
    {
        abort_if($request->user()->id !== $user->id, 404);
        abort_if($user->image === null || ! Storage::exists($user->image), 404);

        return response()->file(Storage::path($user->image));
    }

    private function photoUrl(User $user): string
    {
        return $user->image !== null
            ? route('profile.photo', $user)
            : $user->profile_photo_url;
    }

    public function password(): View
    {
        return view('frontend.dashboard.password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        return redirect()->route('dashboard.password')->with('status', __('Password changed successfully.'));
    }
}
