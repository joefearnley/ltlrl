<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_access_dashboard_when_not_authenticated()
    {
        $this->get(route('dashboard'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_can_access_dashboard_when_authenticated()
    {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertViewIs('dashboard')
            ->assertSee('Dashboard');
    }

    public function test_dashboard_contains_no_urls()
    {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Latest Urls')
            ->assertSee('No Urls Made Little Yet.')
            ->assertSee('Create One');
    }

    public function test_dashboard_contains_latest_urls()
    {
        Url::factory()->count(5)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Latest Urls');


        $data = $response->getOriginalContent()->getData();

        $this->assertGreaterThan(0, $data['recentUrls']->count());
    }

    public function test_dashboard_contains_no_latest_actvity()
    {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Latest Activity')
            ->assertSee('No Activity Yet!')
            ->assertSee('Click on the Create Url link to get started.');
    }


    public function test_dashboard_contains_no_most_active_urls()
    {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Latest Activity')
            ->assertSee('No Active Urls Yet!')
            ->assertSee('Click on the Create Url link to get started.');
    }
}
