<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_create_url_without_url(): void
    {
        $postData = [];

        $this->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHasErrors('url');
    }

    public function test_cannot_create_url_without_valid_url(): void
    {
        $postData = [
            'url' => 'this_is_a_test',
        ];

        $this->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHasErrors('url');
    }

    public function test_can_create_url(): void
    {
        $url = 'https://www.google.com';

        $postData = [
            'url' => $url,
        ];

        $this->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHas('littleUrl');

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'user_id' => null,
        ]);
    }

    public function test_can_create_user_url(): void
    {
        $user = User::factory()->create();
        $url = 'https://www.google.com';

        $postData = [
            'url' => $url,
        ];

        $this->actingAs($user)
            ->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHas('littleUrl');

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'user_id' => $user->id,
        ]);
    }
}
