<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateUserUrlTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_create_url_without_url(): void
    {
        $postData = [
            'url' => '',
            'user_id' => $this->user->id,
        ];

        $this->actingAs($this->user)
            ->postJson(route('urls.store'), $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url field is required.']);;
    }

    public function test_cannot_create_url_without_valid_url(): void
    {
        $postData = [
            'url' => 'this_is_a_test',
            'user_id' => $this->user->id,
        ];

        $this->actingAs($this->user)
            ->postJson(route('urls.store'), $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url field must be a valid URL.']);
    }

    public function test_can_create_url(): void
    {
        $url = 'https://www.google.com';

        $postData = [
            'url' => 'https://www.google.com',
            'user_id' => $this->user->id,
        ];

        $this->postJson(route('urls.store'), $postData)
            ->assertStatus(201)
            ->assertJsonFragment(['url' => $url]);

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'user_id' => $this->user->id,
        ]);
    }
}
