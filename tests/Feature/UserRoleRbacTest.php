<?php

use App\Models\User;

test('public registration page is disabled', function () {
    $response = $this->get('/register');
    $response->assertNotFound();
});

test('only administrator can access user management page', function () {
    $staff = User::factory()->create(['role' => 'staff']);
    $doctor = User::factory()->create(['role' => 'doctor']);
    $admin = User::factory()->create(['role' => 'admin']);

    // Staff denied (403)
    $this->actingAs($staff)->get(route('users.index'))->assertForbidden();

    // Doctor denied (403)
    $this->actingAs($doctor)->get(route('users.index'))->assertForbidden();

    // Admin allowed (200)
    $this->actingAs($admin)->get(route('users.index'))->assertOk();
});
