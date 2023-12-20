<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class SearchUrlTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_search_urls_when_not_authenticated(): void
    {
        $formData = [
            's' => 'test',
        ];

        $this->get(route('urls.search'), $formData)
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_search_urls_when_there_are_no_urls(): void
    {
        $formData = [
            's' => 'test',
        ];

        $this->actingAs($this->user)
            ->get(route('urls.search', $formData))
            ->assertStatus(200)
            ->assertSee('No Urls Found.');
    }

    public function test_can_search_urls_by_title(): void
    {
        $url = Url::factory()->create([
            'title' => 'Test Url',
            'url' => 'https://google.com',
            'user_id' => $this->user->id,
        ]);

        $formData = [
            's' => 'test',
        ];

        $this->actingAs($this->user)
            ->get(route('urls.search'), $formData)
            ->assertStatus(200)
            ->assertSee($url->title)
            ->assertSee($url->url);
    }
}
