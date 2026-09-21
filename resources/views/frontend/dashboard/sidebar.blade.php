<div class="product-sidebar mb-4">
    <div class="single-widget">
        <h3>{{ __('My Account') }}</h3>
        <ul class="list">
            <li>
                <a href="{{ route('dashboard') }}" @class(['fw-bold text-dark' => $active === 'overview'])>{{ __('Dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('dashboard.orders') }}" @class(['fw-bold text-dark' => $active === 'orders'])>{{ __('My Orders') }}</a>
            </li>
            <li>
                <a href="{{ route('dashboard.profile') }}" @class(['fw-bold text-dark' => $active === 'profile'])>{{ __('Profile Settings') }}</a>
            </li>
            <li>
                <a href="{{ route('dashboard.password') }}" @class(['fw-bold text-dark' => $active === 'password'])>{{ __('Change Password') }}</a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Logout') }}</a>
                </form>
            </li>
        </ul>
    </div>
</div>
