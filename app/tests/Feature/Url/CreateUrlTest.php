<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateUrlTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_create_url_without_url(): void
    {
        $postData = [];

        $this->actingAs($this->user)
            ->from(route('urls.create'))
            ->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHasErrors('url')
            ->assertRedirect(route('urls.create'));
    }

    public function test_cannot_create_url_without_valid_url(): void
    {
        $postData = [
            'url' => 'this_is_a_test',
        ];

        $this->actingAs($this->user)
            ->from(route('urls.create'))
            ->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHasErrors('url');
    }

    public function test_can_create_url(): void
    {
        $url = 'https://www.google.com';

        $postData = [
            'url' => $url,
        ];

        $this->actingAs($this->user)
            ->from(route('urls.create'))
            ->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHas('littleUrl');

        $this->assertDatabaseHas('urls', [
            'url' => $url,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_can_create_url_and_title(): void
    {
        $user = User::factory()->create();
        $title = 'This is a Title';
        $url = 'https://www.google.com';

        $postData = [
            'title' => $title,
            'url' => $url,
        ];

        $this->actingAs($user)
            ->from(route('urls.create'))
            ->post(route('urls.store'), $postData)
            ->assertStatus(302)
            ->assertSessionHas('littleUrl')
            ->assertRedirect(route('urls.index'));

        $this->assertDatabaseHas('urls', [
            'title' => $title,
            'url' => $url,
            'user_id' => $user->id,
        ]);
    }
}
