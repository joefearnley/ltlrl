<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class RedirectUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_little_url_that_does_not_exist(): void
    {
        $this->get('/sfasdfsdsa')
            ->assertStatus(404);
    }

    public function test_little_url_redirects_to_correct_url(): void
    {
        $url = Url::factory()->create();

        $this->get($url->little_url)
            ->assertStatus(302)
            ->assertRedirect($url->url);
    }

    public function test_little_url_redirects_to_correct_route(): void
    {
        $url = Url::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }
}
