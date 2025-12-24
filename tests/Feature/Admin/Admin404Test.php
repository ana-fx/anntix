<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Admin404Test extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_return_custom_404_view()
    {
        // Act
        $response = $this->get('/admin/non-existent-page');

        // Assert
        $response->assertStatus(404);
        $response->assertViewIs('errors.404-admin');
    }

    public function test_normal_routes_do_not_return_custom_404_view()
    {
        // Act
        $response = $this->get('/non-existent-page');

        // Assert
        $response->assertStatus(404);
        $response->assertViewMissing('errors.404-admin');
    }
}
