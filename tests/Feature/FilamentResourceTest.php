<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FilamentResourceTest extends TestCase
{
    use DatabaseTransactions;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::first() ?? User::factory()->create([
            'email' => 'admin_test@dinsos.blitarkab.go.id',
            'is_active' => true,
        ]);

        if (! $this->adminUser->hasRole('super_admin')) {
            $this->adminUser->assignRole('super_admin');
        }
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin');

        $response->assertSuccessful();
        $response->assertSeeLivewire('language-switch-component');
    }

    public function test_all_phase_resources_are_accessible_on_index(): void
    {
        $routes = [
            // Phase 1 - Master Data & Users
            '/admin/districts',
            '/admin/villages',
            '/admin/work-units',
            '/admin/users',
            '/admin/service-types',
            '/admin/dtsen-purposes',
            '/admin/client-categories',
            '/admin/complaint-categories',
            '/admin/referral-institutions',

            // Phase 2 - Pelayanan Sosial
            '/admin/service-requests',

            // Phase 3 - Rehabilitasi Sosial
            '/admin/clients',
            '/admin/rehabilitation-cases',

            // Phase 4 - Pengaduan Sosial
            '/admin/complaints',

            // Phase 5 - Pusat Informasi
            '/admin/information-pages',
            '/admin/faqs',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($this->adminUser)->get($route);
            $response->assertSuccessful();
        }
    }
}
