<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class ListUrlsPageTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_view_url_list_page_when_not_authenticated(): void
    {
        $this->get(route('urls.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_view_url_list_page() : void
    {
        $urls = Url::factory()->count(3)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('urls.index'))
            ->assertStatus(200)
            ->assertSee('Little Urls');

        $urls->each(function (Url $url) use($response) {
            $response->assertSee($url->title)
                ->assertSee($url->little_url)
                ->assertSee($url->created_at->format('M j, Y'));
        });
    }

    public function test_view_empty_url_list_page() : void
    {
        $response = $this->actingAs($this->user)
            ->get(route('urls.index'))
            ->assertStatus(200)
            ->assertSee('Little Urls')
            ->assertSee('No Urls Made Little Yet.')
            ->assertSee('Create One');
    }
}
