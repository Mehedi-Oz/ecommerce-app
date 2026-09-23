<?php

use App\Models\Admin;

test('admin sidebar includes a view store link', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin');

    $response = $this->get(route('admin.dashboard'))->assertOk();

    $response->assertSee('View Store', false);
    $response->assertSee(route('home'), false);
    $response->assertSee('target="_blank"', false);
});
