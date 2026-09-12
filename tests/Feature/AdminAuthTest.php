<?php

use App\Models\Admin;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('admin login screen can be rendered', function () {
    $response = $this->get(route('admin.login'));

    $response->assertStatus(200);
});

test('unauthenticated admin is redirected to admin login', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('admin can authenticate using correct credentials', function () {
    $admin = Admin::factory()->create();

    $response = $this->post(route('admin.login'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard', absolute: false));
    $this->assertAuthenticated('admin');
});

test('admin cannot authenticate with invalid password', function () {
    $admin = Admin::factory()->create();

    $this->post(route('admin.login'), [
        'email' => $admin->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest('admin');
});

test('authenticated admin is redirected to dashboard when visiting login page', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get(route('admin.login'));

    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('authenticated admin can view the dashboard page', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin')
        ->get(route('admin.dashboard'))
        ->assertOk();
});

test('admin can logout', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->post(route('admin.logout'));

    $response->assertRedirect(route('admin.login'));
    $this->assertGuest('admin');
});

test('admin forgot password screen can be rendered', function () {
    $response = $this->get(route('admin.password.request'));

    $response->assertStatus(200);
});

test('admin reset password screen can be rendered', function () {
    $response = $this->get(route('admin.password.reset', ['token' => 'test-token']));

    $response->assertStatus(200);
});

test('admin forgot password sends reset link', function () {
    Notification::fake();

    $admin = Admin::factory()->create();

    $this->post(route('admin.password.email'), [
        'email' => $admin->email,
    ]);

    Notification::assertSentTo($admin, ResetPassword::class);
});

test('existing frontend web auth is unaffected by admin middleware', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);

    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});
