<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class StoreUrlTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_create_url_when_not_authenticated(): void
    {
        $url = 'https://www.google.com';

        $formData = [
            'url' => $url,
        ];

        $this->post(route('urls.store'), $formData)
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_cannot_create_url_with_no_form_data(): void
    {
        $formData = [];

        $this->actingAs($this->user)
            ->post(route('urls.store'), $formData)
            ->assertStatus(302)
            ->assertSessionHasErrors(['url' => 'The url field is required.']);
    }

    public function test_cannot_create_url_with_no_url(): void
    {
        $formData = [
            'url' => ''
        ];

        $this->actingAs($this->user)
            ->post(route('urls.store'), $formData)
            ->assertStatus(302)
            ->assertSessionHasErrors(['url' => 'The url field is required.']);
    }

    public function test_can_create_url(): void
    {
        $url = 'https://www.google.com';

        $formData = [
            'url' => $url,
        ];

        $this->actingAs($this->user)
            ->post(route('urls.store'), $formData)
            ->assertStatus(302)
            ->assertSessionHas('message')
            ->assertSessionHas('littleUrl')
            ->assertRedirect();

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_can_create_title_and_url(): void
    {
        $title = 'Google';
        $url = 'https://www.google.com';

        $formData = [
            'title' => $title,
            'url' => $url,
        ];

        $this->actingAs($this->user)
            ->post(route('urls.store'), $formData)
            ->assertStatus(302)
            ->assertSessionHas('message')
            ->assertSessionHas('littleUrl')
            ->assertRedirect(route('urls.index'));

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'title' => $title,
            'user_id' => $this->user->id,
        ]);
    }
}
