<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;

test('user seeder plants the default frontend account', function () {
    $this->seed(UserSeeder::class);

    $user = User::where('email', 'user@gmail.com')->firstOrFail();

    expect(Hash::check('12345678', $user->password))->toBeTrue();
});

test('user seeder is safe to rerun', function () {
    $this->seed(UserSeeder::class);
    $this->seed(UserSeeder::class);

    expect(User::where('email', 'user@gmail.com')->count())->toBe(1);
});
