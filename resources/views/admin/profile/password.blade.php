@extends('admin.layouts.master')

@section('title', 'Change Password')

@section('content')
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Change Password</h4>
                    <h6 class="card-subtitle">Enter your current password and choose a new one</h6>
                    <form class="form-horizontal p-t-20" method="POST"
                        action="{{ route('admin.password.update') }}">
                        @csrf
                        @method('PUT')

                        <x-admin.input-text type="password" name="current_password" :label="__('Current Password')" autocomplete="current-password" required />

                        <x-admin.input-text type="password" name="password" :label="__('New Password')" autocomplete="new-password" required />

                        <x-admin.input-text type="password" name="password_confirmation" :label="__('Confirm New Password')" autocomplete="new-password" required />

                        <div class="mt-3 d-flex gap-2">
                            <x-admin.submit-button :label="__('Update Password')" />
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary waves-effect waves-light text-white">Back to Profile</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .password-toggle-wrapper {
            position: relative;
        }
        .password-toggle-wrapper input {
            padding-right: 40px;
        }
        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: 0;
            padding: 0;
            cursor: pointer;
            color: #888;
            font-size: 16px;
            line-height: 1;
        }
        .password-toggle-btn.showing {
            color: #03a9f3;
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            document.querySelectorAll('input[type="password"]').forEach(function (input) {
                var wrapper = document.createElement('div');
                wrapper.className = 'password-toggle-wrapper';
                input.after(wrapper);
                wrapper.appendChild(input);

                var btn = document.createElement('button');
                btn.setAttribute('type', 'button');
                btn.className = 'password-toggle-btn';
                btn.setAttribute('aria-label', 'Show password');
                btn.innerHTML = '<i class="fa fa-eye"></i>';
                btn.addEventListener('click', function () {
                    var show = input.getAttribute('type') === 'password';
                    input.setAttribute('type', show ? 'text' : 'password');
                    btn.querySelector('i').className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
                    btn.classList.toggle('showing', show);
                    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                });
                wrapper.appendChild(btn);
            });
        })();
    </script>
@endpush
