<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Click;
use App\Models\Url;

class StoreUrlTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_create_url_with_no_url()
    {
        $formData = [];

        $this->actingAs($this->user)
            ->get(route('urls.store'))
            ->assertStatus(200);
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
            ->assertSessionHas('littleUrl');

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
            ->assertSessionHas('littleUrl');

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'title' => $title,
            'user_id' => $this->user->id,
        ]);
    }
}
