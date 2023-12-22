<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class ShowUrlPageTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->url = Url::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function test_cannot_view_url_page_when_not_authenticated(): void
    {
        $this->get(route('urls.show', $this->url))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function test_cannot_view_url_page_of_url_user_does_not_own(): void
    {
        $differentUser = User::factory()->create();
        $differentUsersUrl = Url::factory()->create([
            'user_id' => $differentUser->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('urls.show', $differentUsersUrl))
            ->assertStatus(403);
    }

    public function test_create_url_page_shows_form(): void
    {
        $this->actingAs($this->user)
            ->get(route('urls.edit', $this->url))
            ->assertStatus(200)
            ->assertSee($this->url->title)
            ->assertSee($this->url->url);
    }
}
