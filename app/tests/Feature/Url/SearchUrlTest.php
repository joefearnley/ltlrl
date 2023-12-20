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

        $this->get(route('urls.search', $formData))
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
            ->assertViewIs('urls.url-list')
            ->assertSeeText('No Urls Found.');
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
            ->get(route('urls.search', $formData))
            ->assertStatus(200)
            ->assertViewIs('urls.url-list')
            ->assertSeeText($url->title)
            ->assertSeeText($url->url);
    }

    public function test_can_search_urls_by_url(): void
    {
        $url = Url::factory()->create([
            'title' => 'The Best Url',
            'url' => 'https://test.com',
            'user_id' => $this->user->id,
        ]);

        $formData = [
            's' => 'test',
        ];

        $this->actingAs($this->user)
            ->get(route('urls.search', $formData))
            ->assertStatus(200)
            ->assertViewIs('urls.url-list')
            ->assertSeeText($url->title)
            ->assertSeeText($url->url);
    }

    public function test_can_search_urls_does_not_find_results(): void
    {
        $url = Url::factory()->create([
            'title' => 'The Best Url',
            'url' => 'https://test.com',
            'user_id' => $this->user->id,
        ]);

        $formData = [
            's' => 'bluenest',
        ];

        $this->actingAs($this->user)
            ->get(route('urls.search', $formData))
            ->assertStatus(200)
            ->assertViewIs('urls.url-list')
            ->assertSeeText('No Urls Found.')
            ->assertDontSeeText($url->title)
            ->assertDontSeeText($url->url);
    }
}
