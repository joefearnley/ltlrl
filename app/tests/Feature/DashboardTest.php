<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;
use App\Models\Click;

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

    public function test_dashboard_contains_latest_activity()
    {
        $urls = Url::factory()->count(5)->create([
            'user_id' => $this->user->id,
        ]);

        $urlsClicked = $urls->take(3);

        foreach($urlsClicked as $url) {
            Click::factory()->create([
                'url_id' => $url->id,
            ]);
        }

        $response = $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Latest Activity');


        foreach($urlsClicked as $url) {
            $response->assertSee($url->title)
                ->assertSee($url->url)
                ->assertSee($url->little_url);
        }

        $data = $response->getOriginalContent()->getData();

        $this->assertEquals(3, $data['latestClicks']->count());
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

    public function test_dashboard_contains_most_active_urls()
    {
        $urls = Url::factory()->count(15)->create([
            'user_id' => $this->user->id,
        ]);

        $urlsClicked = $urls->take(5);

        foreach($urlsClicked as $url) {
            Click::factory()->count(2)->create([
                'url_id' => $url->id,
            ]);
        }

        // create clicks on 10 of these urls 5 on one
        // assert the count is 10
        // assert these urls' data and click count shows on on page

        $response = $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Most Active Urls');

        foreach($urlsClicked as $url) {
            $response->assertSee($url->title)
                ->assertSee($url->url)
                ->assertSee($url->little_url)
                ->assertSee($url->clicks->count() . ' Clicks');
        }

        $data = $response->getOriginalContent()->getData();

        $this->assertEquals(5, $data['recentUrls']->count());
    }
}
