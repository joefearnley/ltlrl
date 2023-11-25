<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Click;
use App\Models\Url;

class CreateUrlPageTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_view_create_url_page_when_not_authenticated(): void
    {
        $this->get(route('urls.create'))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function test_can_view_create_url_page_when_authenticated(): void
    {
        $this->actingAs($this->user)
            ->get(route('urls.create'))
            ->assertStatus(200);
    }

    public function test_create_url_page_shows_form(): void
    {
        $this->actingAs($this->user)
            ->get(route('urls.create'))
            ->assertStatus(200)
            ->assertSee('Create Url')
            ->assertSee('Create an Url')
            ->assertSee('Enter a url and make it little.')
            ->assertSee('Title')
            ->assertSee('Url');
    }
}
