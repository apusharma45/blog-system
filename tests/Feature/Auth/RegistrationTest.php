<?php

use Livewire\Volt\Volt;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = Volt::test('auth.register')
        ->set('name', 'Test User')
        ->set('username', 'testuser')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register');

    $user = \App\Models\User::where('email', 'test@example.com')->first();

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', ['username' => $user->username], absolute: false));

    $this->assertAuthenticated();
});
