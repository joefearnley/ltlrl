<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class EditUrlPageTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->url = Url::factory()->create();
    }

    public function test_cannot_view_edit_url_page_when_not_authenticated(): void
    {
        $this->get(route('urls.show', $this->url))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function test_can_view_edit_url_page_when_authenticated(): void
    {
        $this->actingAs($this->user)
            ->get(route('urls.show', $this->url))
            ->assertStatus(200);
    }

    public function test_create_url_page_shows_form(): void
    {
        $this->actingAs($this->user)
            ->get(route('urls.show', $this->url))
            ->assertStatus(200)
            ->assertSee('Edit Url')
            ->assertSee('Update Url')
            ->assertSee('Make any changes and click Save.')
            ->assertSee('Title')
            ->assertSee('Url')
            ->assertSee($this->url->title)
            ->assertSee($this->url->url);
    }
}
